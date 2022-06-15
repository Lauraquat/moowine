<?php

namespace PaymentPlugins\Stripe\WooCommerceSubscriptions\Controllers;

use PaymentPlugins\Stripe\WooCommerceSubscriptions\FrontendRequests;

class PaymentIntent {

	private $request;

	public function __construct( FrontendRequests $request ) {
		$this->request = $request;
		$this->initialize();
	}

	private function initialize() {
		add_filter( 'wc_stripe_create_setup_intent', [ $this, 'maybe_create_setup_intent' ] );
	}

	public function maybe_create_setup_intent( $bool ) {
		if ( ! $bool ) {
			if ( $this->request->is_change_payment_method() ) {
				$bool = true;
			} elseif ( $this->request->is_checkout_with_free_trial() ) {
				$bool = true;
			} elseif ( $this->request->is_order_pay_with_free_trial() ) {
				$bool = true;
			}
		}

		return $bool;
	}

}