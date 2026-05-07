<?php
namespace App\Filters;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		$session = session();
		// Debug: log requested URI and session status
		$uri = $request->getURI();
		log_message('debug', '[AuthFilter] requested URI: ' . ($uri ? (string)$uri : '[none]'));
		log_message('debug', '[AuthFilter] session user present: ' . ($session->get('user') ? 'yes' : 'no'));
		// Si pas connecté → redirection login  
		if (!$session->get('user')) {
			log_message('info', '[AuthFilter] redirecting to / because user not authenticated');
			return redirect()->to('/')->with('erreur', 'Connectez-vous pour accéder à cette page');
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Rien à faire après
	}
}