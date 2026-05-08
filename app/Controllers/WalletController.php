<?php

namespace App\Controllers;

use App\Models\CouponModel;
use App\Models\CouponRedemptionModel;
use App\Models\WalletModel;

class WalletController extends BaseController
{
    private function currentUserId(): ?int
    {
        $user = session()->get('user');

        if (is_array($user) && isset($user['id'])) {
            return (int) $user['id'];
        }

        $id = session()->get('id');
        return $id ? (int) $id : null;
    }

    public function index()
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        try {
            $db = db_connect();
            if (!$db->tableExists('wallets') || !$db->tableExists('coupons') || !$db->tableExists('coupon_redemptions')) {
                session()->setFlashdata('error', 'Le module portefeuille n\'est pas encore prêt en base de données. Lancez d\'abord les migrations.');
                return view('pages/wallet/index', [
                    'wallet'  => ['balance' => 0],
                    'history' => [],
                ]);
            }

            $walletModel = new WalletModel();
            $redemptionModel = new CouponRedemptionModel();

            $wallet = $walletModel->getOrCreateByUserId($userId);
            $history = $redemptionModel->where('user_id', $userId)
                ->orderBy('redeemed_at', 'DESC')
                ->findAll(10);

            return view('pages/wallet/index', [
                'wallet'  => $wallet,
                'history' => $history,
            ]);
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Portefeuille indisponible pour le moment (base de données non prête).');
            return view('pages/wallet/index', [
                'wallet'  => ['balance' => 0],
                'history' => [],
            ]);
        }
    }

    public function redeemCoupon()
    {
        $userId = $this->currentUserId();
        if (!$userId) {
            return redirect()->to('/login');
        }

        try {
            $db = db_connect();
            if (!$db->tableExists('wallets') || !$db->tableExists('coupons') || !$db->tableExists('coupon_redemptions')) {
                session()->setFlashdata('error', 'Impossible d\'appliquer un coupon: tables portefeuille absentes.');
                return redirect()->to('/wallet');
            }
        } catch (\Throwable $e) {
            session()->setFlashdata('error', 'Impossible d\'appliquer un coupon: base de données indisponible.');
            return redirect()->to('/wallet');
        }

        $code = (string) $this->request->getPost('code');
        if (trim($code) === '') {
            session()->setFlashdata('error', 'Veuillez entrer un code coupon.');
            return redirect()->to('/wallet');
        }

        $walletModel = new WalletModel();
        $couponModel = new CouponModel();
        $redemptionModel = new CouponRedemptionModel();

        $coupon = $couponModel->findValidByCode($code);
        if (!$coupon) {
            session()->setFlashdata('error', 'Coupon invalide, expiré ou non disponible.');
            return redirect()->to('/wallet');
        }

        if ($redemptionModel->alreadyRedeemed($userId, (int) $coupon['id'])) {
            session()->setFlashdata('error', 'Vous avez déjà utilisé ce coupon.');
            return redirect()->to('/wallet');
        }

        $db = db_connect();
        $db->transStart();

        $walletModel->addBalance($userId, (float) $coupon['amount']);

        $redemptionModel->insert([
            'user_id'     => $userId,
            'coupon_id'   => $coupon['id'],
            'amount'      => $coupon['amount'],
            'redeemed_at' => date('Y-m-d H:i:s'),
        ]);

        $couponModel->update($coupon['id'], [
            'used_count' => (int) $coupon['used_count'] + 1,
        ]);

        $db->transComplete();

        if (!$db->transStatus()) {
            session()->setFlashdata('error', 'Erreur lors de l\'application du coupon.');
            return redirect()->to('/wallet');
        }

        session()->setFlashdata('success', 'Coupon appliqué: +' . number_format((float) $coupon['amount'], 2) . ' Ar');
        return redirect()->to('/wallet');
    }
}
