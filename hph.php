<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>

<form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_table' ); ?>
	
	

<table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents d-none" cellspacing="0">
  <tbody>
    <?php do_action( 'woocommerce_before_cart_contents' ); ?>

    <?php
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
      $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
      $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
      /**
       * Filter the product name.
       *
       * @since 2.1.0
       * @param string $product_name Name of the product in the cart.
       * @param array $cart_item The product in the cart.
       * @param string $cart_item_key Key for the product in the cart.
       */
      $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

      if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
        ?>
        <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

          <td class="product-remove">
            <?php
              echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                'woocommerce_cart_item_remove_link',
                sprintf(
                  '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                  esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                  /* translators: %s is the product name */
                  esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
                  esc_attr( $product_id ),
                  esc_attr( $_product->get_sku() )
                ),
                $cart_item_key
              );
            ?>
          </td>

          <td class="product-thumbnail">
          <?php
          $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

          if ( ! $product_permalink ) {
            echo $thumbnail; // PHPCS: XSS ok.
          } else {
            printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
          }
          ?>
          </td>

          <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
          <?php
          if ( ! $product_permalink ) {
            echo wp_kses_post( $product_name . '&nbsp;' );
          } else {
            /**
             * This filter is documented above.
             *
             * @since 2.1.0
             */
            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
          }

          do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

          // Meta data.
          echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

          // Backorder notification.
          if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
          }
          ?>
          </td>

          <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
            <?php
              echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
            ?>
          </td>

          <td class="product-quantity" data-title="<?php// esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
          <?php
//           if ( $_product->is_sold_individually() ) {
//             $min_quantity = 1;
//             $max_quantity = 1;
//           } else {
//             $min_quantity = 0;
//             $max_quantity = $_product->get_max_purchase_quantity();
//           }

//           $product_quantity = woocommerce_quantity_input(
//             array(
//               'input_name'   => "cart[{$cart_item_key}][qty]",
//               'input_value'  => $cart_item['quantity'],
//               'max_value'    => $max_quantity,
//               'min_value'    => $min_quantity,
//               'product_name' => $product_name,
//             ),
//             $_product,
//             false
//           );

//           echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
// //           ?>
          </td>

          <td class="product-subtotal" data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>">
            <?php
              echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
            ?>
          </td>
        </tr>
        <?php
      }
    }
    ?>

    <?php// do_action( 'woocommerce_cart_contents' ); ?>

    <tr>
      <td colspan="6" class="actions">

        


      </td>
    </tr>

    <?php // do_action( 'woocommerce_after_cart_contents' ); ?>
  </tbody>
</table>
	<?php // do_action( 'woocommerce_after_cart_table' ); ?>
	
   <!-- ! basket-section starts  -->
    <section class="basket-section">
      <div class="cont">
        <div class="heading">
          <div class="line"></div>
          <h1>Корзина</h1>
        </div>

        <div class="big-wrapper">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>
          <div class="card-side">
			      <?php/* do_action( 'woocommerce_before_cart_contents' ); */?>

    <?php
    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
      $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
      $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
      /**
       * Filter the product name.
       *
       * @since 2.1.0
       * @param string $product_name Name of the product in the cart.
       * @param array $cart_item The product in the cart.
       * @param string $cart_item_key Key for the product in the cart.
       */
      $product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

      if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
        $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
        ?>
            <div class="card-basket">
              <div class="wrapper">
                <div class="img-wrapper">
                  <?php
						$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

						if ( ! $product_permalink ) {
							echo $thumbnail; // PHPCS: XSS ok.
						} else {
							printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
						}
						?>
                </div>
                <div class="name-specifications">
   <h2 data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
					<?php
						if ( ! $product_permalink ) {
							echo wp_kses_post( $product_name . '&nbsp;' );
						} else {
							/**
							 * This filter is documented above.
							 *
							 * @since 2.1.0
							 */
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
						}

						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

						// Meta data.
						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

						// Backorder notification.
						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
						}
						?>
					</h2>

                  <div class="specifications">
                    <h3>Характеристики</h3>
                    <div class="inner">
                      <ul class="left">
                        <li>Цвет :</li>
                        <li>Материалы :</li>
                        <li>Размер :</li>
                      </ul>
                      <ul class="right">
                        <li>Белый</li>
                        <li>Дерево, металл</li>
                        <li>100 см х 100 см х 100 см</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="mobile-options mobile-delete">
					<?php echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove delete" aria-label="%s" data-product_id="%s" data-product_sku="%s">Удалить</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
                </div>
              </div>

              <div class="options">
	 				<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove delete" aria-label="%s" data-product_id="%s" data-product_sku="%s">Удалить</a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										/* translators: %s is the product name */
										esc_attr( sprintf( __( 'Remove %s from cart', 'woocommerce' ), wp_strip_all_tags( $product_name ) ) ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
                <div class="increment">
					 <?php
          if ( $_product->is_sold_individually() ) {
            $min_quantity = 1;
            $max_quantity = 1;
          } else {
            $min_quantity = 0;
            $max_quantity = $_product->get_max_purchase_quantity();
          }

          $product_quantity = woocommerce_quantity_input(
            array(
              'input_name'   => "cart[{$cart_item_key}][qty]",
              'input_value'  => $cart_item['quantity'],
              'max_value'    => $max_quantity,
              'min_value'    => $min_quantity,
              'product_name' => $product_name,
            ),
            $_product,
            false
          );

          echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
          ?>	
                </div>
                <div class="per-price">
                  <p>	<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?></p>
                </div>
              </div>

              <div class="mobile-options">
             
                <div class="per-price">
                  <p>	<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?></p>
                </div>
              </div>
            </div>
			  <?php
      }
    }
    ?>
			   
          </div>
			<?php do_action( 'woocommerce_after_cart_table' ); ?>
          <div class="price-side">
            <div class="receipt">
				<?php
// 			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
// 				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
// 				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
// 				/**
// 				 * Filter the product name.
// 				 *
// 				 * @since 2.1.0
// 				 * @param string $product_name Name of the product in the cart.
// 				 * @param array $cart_item The product in the cart.
// 				 * @param string $cart_item_key Key for the product in the cart.
// 				 */
// 				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );

// 				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
// 					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
// 					?>
              <div class="name-price">
                <h3><?php
// 						if ( ! $product_permalink ) {
// 							echo wp_kses_post( $product_name . '&nbsp;' );
// 						} else {
// 							/**
// 							 * This filter is documented above.
// 							 *
// 							 * @since 2.1.0
// 							 */
// 							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
// 						}

// 						do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );

// 						// Meta data.
// 						echo wc_get_formatted_cart_item_data( $cart_item ); // PHPCS: XSS ok.

// 						// Backorder notification.
// 						if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
// 							echo wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'woocommerce' ) . '</p>', $product_id ) );
// 						}
						?></h3>
                <p><?php
// 								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
							?></p>
              </div>
              <?php
// 				}
// 			}
			?>
				<?php do_action( 'woocommerce_cart_contents' ); ?>
              <div class="total">
                <h3>Общаяя сумма</h3>
                <p><?php wc_cart_totals_order_total_html(); ?></p>
              </div>
				<button id="my-button" type="button" class="custom-update-button custom-btn ">Update</button>
<button type="submit" class=" button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>

        <?php do_action( 'woocommerce_cart_actions' ); ?>

        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
              <a href="\checkout" class="custom-btn">Оформление заказа</a>
            </div>
			  <?php do_action( 'woocommerce_after_cart_contents' ); ?>
          </div>
        </div>
      </div>
    </section>
    <!-- ! basket-section ends -->
</form>

    <!-- ! section catalog starts -->
    <section class="catalog product_catalog to_catalog" id="catalog">
      <div class="cont">
        <div class="heading">
          <div class="left">
            <div class="line"></div>
            <h1>Рекомундуем для вас</h1>
          </div>
        </div>
		  <div class="small-cards">
          <div class="swiper swiper-small-cards">
            <div class="swiper-wrapper">
				<?php echo do_shortcode('[swiper_item_main]');?>
            </div>
          </div>
          <div class="swiper-button-prev to_catalog_prev"></div>
          <div class="swiper-button-next to_catalog_next"></div>
        </div>
      </div>
    </section>
    <!-- ! section catalog ends -->

<?php// do_action( 'woocommerce_before_cart_collaterals' ); ?>

<div class="cart-collaterals">
	<?php
		/**
		 * Cart collaterals hook.
		 *
		 * @hooked woocommerce_cross_sell_display
		 * @hooked woocommerce_cart_totals - 10
		 */
		//do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

<?php do_action( 'woocommerce_after_cart' ); ?>









--------$_COOKIE




<?php
/**
 * Cart totals
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-totals.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.3.6
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<table cellspacing="0" class="shop_table shop_table_responsive">

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Subtotal', 'woocommerce' ); ?>"><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td data-title="<?php echo esc_attr( $fee->name ); ?>"><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'woocommerce' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}

			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
						<td data-title="<?php echo esc_attr( $tax->label ); ?>"><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
					<?php
				}
			} else {
				?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></th>
					<td data-title="<?php echo esc_attr( WC()->countries->tax_or_vat() ); ?>"><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
				<?php
			}
		}
		?>

		<?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>"><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>

	</table>
		 <button type="submit" class=" button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
	<div class="wc-proceed-to-checkout">
		<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
	</div>

	<?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>








<table class="shop_table woocommerce-checkout-review-order-table receipt">
	<thead>
		<tr>
			<th class="product-name"><?php esc_html_e( 'Product', 'woocommerce' ); ?></th>
			<th class="product-total"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		do_action( 'woocommerce_review_order_before_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="name-price <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
					<td class="product-name ">
						<?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
						<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
					<td class="product-total ">
						<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_review_order_after_cart_contents' );
		?>
	</tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>




-------$_COOKIE




<?php
/**
 * Wishlist page template - Standard Layout
 *
 * @author YITH <plugins@yithemes.com>
 * @package YITH\Wishlist\Templates\Wishlist\View
 * @version 3.0.0
 */

/**
 * Template variables:
 *
 * @var $wishlist                      \YITH_WCWL_Wishlist Current wishlist
 * @var $wishlist_items                array Array of items to show for current page
 * @var $wishlist_token                string Current wishlist token
 * @var $wishlist_id                   int Current wishlist id
 * @var $users_wishlists               array Array of current user wishlists
 * @var $pagination                    string yes/no
 * @var $per_page                      int Items per page
 * @var $current_page                  int Current page
 * @var $page_links                    array Array of page links
 * @var $is_user_owner                 bool Whether current user is wishlist owner
 * @var $show_price                    bool Whether to show price column
 * @var $show_dateadded                bool Whether to show item date of addition
 * @var $show_stock_status             bool Whether to show product stock status
 * @var $show_add_to_cart              bool Whether to show Add to Cart button
 * @var $show_remove_product           bool Whether to show Remove button
 * @var $show_price_variations         bool Whether to show price variation over time
 * @var $show_variation                bool Whether to show variation attributes when possible
 * @var $show_cb                       bool Whether to show checkbox column
 * @var $show_quantity                 bool Whether to show input quantity or not
 * @var $show_ask_estimate_button      bool Whether to show Ask an Estimate form
 * @var $show_last_column              bool Whether to show last column (calculated basing on previous flags)
 * @var $move_to_another_wishlist      bool Whether to show Move to another wishlist select
 * @var $move_to_another_wishlist_type string Whether to show a select or a popup for wishlist change
 * @var $additional_info               bool Whether to show Additional info textarea in Ask an estimate form
 * @var $price_excl_tax                bool Whether to show price excluding taxes
 * @var $enable_drag_n_drop            bool Whether to enable drag n drop feature
 * @var $repeat_remove_button          bool Whether to repeat remove button in last column
 * @var $available_multi_wishlist      bool Whether multi wishlist is enabled and available
 * @var $no_interactions               bool
 */

if ( ! defined( 'YITH_WCWL' ) ) {
	exit;
} // Exit if accessed directly
?>

<!-- WISHLIST TABLE -->
<table
	class="shop_table cart wishlist_table wishlist_view traditional responsive <?php echo $no_interactions ? 'no-interactions' : ''; ?> <?php echo $enable_drag_n_drop ? 'sortable' : ''; ?> "
	data-pagination="<?php echo esc_attr( $pagination ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-page="<?php echo esc_attr( $current_page ); ?>"
	data-id="<?php echo esc_attr( $wishlist_id ); ?>" data-token="<?php echo esc_attr( $wishlist_token ); ?>">

	<?php $column_count = 2; ?>

	<thead class="d-none">
	<tr>
		<?php if ( $show_cb ) : ?>
			<?php ++$column_count; ?>
			<th class="product-checkbox">
				<input type="checkbox" value="" name="" id="bulk_add_to_cart"/>
			</th>
		<?php endif; ?>

		<?php if ( $show_remove_product ) : ?>
			<?php ++$column_count; ?>
			<th class="product-remove">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_remove_heading
					 *
					 * Filter the heading of the column to remove the product from the wishlist in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_remove_heading', '', $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<th class="product-thumbnail"></th>

		<th class="product-name">
			<span class="nobr">
				<?php
				/**
				 * APPLY_FILTERS: yith_wcwl_wishlist_view_name_heading
				 *
				 * Filter the heading of the column to show the product name in the wishlist table.
				 *
				 * @param string             $heading  Heading text
				 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
				 *
				 * @return string
				 */
				echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_name_heading', __( 'Product name', 'yith-woocommerce-wishlist' ), $wishlist ) );
				?>
			</span>
		</th>

		<?php if ( $show_price || $show_price_variations ) : ?>
			<?php ++$column_count; ?>
			<th class="product-price">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_price_heading
					 *
					 * Filter the heading of the column to show the product price in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_price_heading', __( 'Unit price', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $show_quantity ) : ?>
			<?php ++$column_count; ?>
			<th class="product-quantity">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_quantity_heading
					 *
					 * Filter the heading of the column to show the product quantity in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_quantity_heading', __( 'Quantity', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $show_stock_status ) : ?>
			<?php ++$column_count; ?>
			<th class="product-stock-status">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_stock_heading
					 *
					 * Filter the heading of the column to show the product stock status in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_stock_heading', __( 'Stock status', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $show_last_column ) : ?>
			<?php ++$column_count; ?>
			<th class="product-add-to-cart">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_cart_heading
					 *
					 * Filter the heading of the cart column in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_cart_heading', '', $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $enable_drag_n_drop ) : ?>
			<?php ++$column_count; ?>
			<th class="product-arrange">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_arrange_heading
					 *
					 * Filter the heading of the column to change order of the items in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_arrange_heading', __( 'Arrange', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>
	</tr>
	</thead>

	<tbody class="wishlist-items-wrapper">
	<?php
	if ( $wishlist && $wishlist->has_items() ) :
		foreach ( $wishlist_items as $item ) :
			/**
			 * Each of the wishlist items
			 *
			 * @var $item \YITH_WCWL_Wishlist_Item
			 */
			global $product;

			$product = $item->get_product();

			if ( $product && $product->exists() ) :
				?>
				<tr id="yith-wcwl-row-<?php echo esc_attr( $item->get_product_id() ); ?>" data-row-id="<?php echo esc_attr( $item->get_product_id() ); ?>">
					<?php if ( $show_cb ) : ?>
						<td class="product-checkbox">
							<input type="checkbox" value="yes" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][cb]"/>
						</td>
					<?php endif ?>

					<?php if ( $show_remove_product ) : ?>
						<td class="product-remove">
							<div>
								<?php
								/**
								 * APPLY_FILTERS: yith_wcwl_remove_product_wishlist_message_title
								 *
								 * Filter the title of the icon to remove the product from the wishlist.
								 *
								 * @param string $title Icon title
								 *
								 * @return string
								 */
								?>
								<a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove remove_from_wishlist" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>">&times;</a>
							</div>
						</td>
					<?php endif; ?>

					<td class="product-thumbnail">
						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_before_product_thumbnail
						 *
						 * Allows to render some content or fire some action before the product thumbnail in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_before_product_thumbnail', $item, $wishlist );
						?>

						<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
							<?php echo wp_kses_post( $product->get_image() ); ?>
						</a>

						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_after_product_thumbnail
						 *
						 * Allows to render some content or fire some action after the product thumbnail in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_after_product_thumbnail', $item, $wishlist );
						?>
					</td>

					<td class="product-name">
						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_before_product_name
						 *
						 * Allows to render some content or fire some action before the product name in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_before_product_name', $item, $wishlist );
						?>

						<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?>
						</a>

						<?php
						if ( $show_variation && $product->is_type( 'variation' ) ) {
							/**
							 * Product is a Variation
							 *
							 * @var $product \WC_Product_Variation
							 */
							echo wp_kses_post( wc_get_formatted_variation( $product ) );
						}
						?>

						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_after_product_name
						 *
						 * Allows to render some content or fire some action after the product name in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_after_product_name', $item, $wishlist );
						?>
					</td>

					<?php if ( $show_price || $show_price_variations ) : ?>
						<td class="product-price">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_price
							 *
							 * Allows to render some content or fire some action before the product price in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_price', $item, $wishlist );
							?>

							<?php
							if ( $show_price ) {
								echo wp_kses_post( $item->get_formatted_product_price() );
							}

							if ( $show_price_variations ) {
								echo wp_kses_post( $item->get_price_variation() );
							}
							?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_price
							 *
							 * Allows to render some content or fire some action after the product price in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_price', $item, $wishlist );
							?>
						</td>
					<?php endif ?>

					<?php if ( $show_quantity ) : ?>
						<td class="product-quantity">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_quantity
							 *
							 * Allows to render some content or fire some action before the product quantity in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_quantity', $item, $wishlist );
							?>

							<?php if ( ! $no_interactions && $wishlist->current_user_can( 'update_quantity' ) ) : ?>
								<input type="number" min="1" step="1" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][quantity]" value="<?php echo esc_attr( $item->get_quantity() ); ?>"/>
							<?php else : ?>
								<?php echo esc_html( $item->get_quantity() ); ?>
							<?php endif; ?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_quantity
							 *
							 * Allows to render some content or fire some action after the product quantity in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_quantity', $item, $wishlist );
							?>
						</td>
					<?php endif; ?>

					<?php if ( $show_stock_status ) : ?>
						<td class="product-stock-status">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_stock
							 *
							 * Allows to render some content or fire some action before the product stock in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_stock', $item, $wishlist );
							?>

							<?php
							/**
							 * APPLY_FILTERS: yith_wcwl_out_of_stock_label
							 *
							 * Filter the label when the product in the wishlist is out of stock.
							 *
							 * @param string $label Label
							 *
							 * @return string
							 */
							/**
							 * APPLY_FILTERS: yith_wcwl_in_stock_label
							 *
							 * Filter the label when the product in the wishlist is in stock.
							 *
							 * @param string $label Label
							 *
							 * @return string
							 */
							$stock_status_html = 'out-of-stock' === $item->get_stock_status() ? '<span class="wishlist-out-of-stock">' . esc_html( apply_filters( 'yith_wcwl_out_of_stock_label', __( 'Out of stock', 'yith-woocommerce-wishlist' ) ) ) . '</span>' : '<span class="wishlist-in-stock">' . esc_html( apply_filters( 'yith_wcwl_in_stock_label', __( 'In Stock', 'yith-woocommerce-wishlist' ) ) ) . '</span>';

							/**
							 * APPLY_FILTERS: yith_wcwl_stock_status
							 *
							 * Filters the HTML for the stock status label.
							 *
							 * @param string                  $stock_status_html Stock status HTML.
							 * @param YITH_WCWL_Wishlist_Item $item              Wishlist item object.
							 * @param YITH_WCWL_Wishlist      $wishlist          Wishlist object.
							 *
							 * @return string
							 */
							echo wp_kses_post( apply_filters( 'yith_wcwl_stock_status', $stock_status_html, $item, $wishlist ) );
							?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_stock
							 *
							 * Allows to render some content or fire some action after the product stock in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_stock', $item, $wishlist );
							?>
						</td>
					<?php endif ?>

					<?php if ( $show_last_column ) : ?>
						<td class="product-add-to-cart">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_cart
							 *
							 * Allows to render some content or fire some action before the product cart in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_cart', $item, $wishlist );
							?>

							<!-- Date added -->
							<?php
							if ( $show_dateadded && $item->get_date_added() ) :
								// translators: date added label: 1 date added.
								echo '<span class="dateadded">' . esc_html( sprintf( __( 'Added on: %s', 'yith-woocommerce-wishlist' ), $item->get_date_added_formatted() ) ) . '</span>';
							endif;
							?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_product_before_add_to_cart
							 *
							 * Allows to render some content or fire some action before the 'Add to cart' in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_product_before_add_to_cart', $item, $wishlist );
							?>

							<!-- Add to cart button -->
							<?php
							/**
							 * APPLY_FILTERS: yith_wcwl_table_product_show_add_to_cart
							 *
							 * Filter if show the 'Add to cart' button in the wishlist table for each product.
							 *
							 * @param bool                    $show_add_to_cart Show 'Add to cart' button or not
							 * @param YITH_WCWL_Wishlist_Item $item             Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist         Wishlist object
							 *
							 * @return bool
							 */
							$show_add_to_cart = apply_filters( 'yith_wcwl_table_product_show_add_to_cart', $show_add_to_cart, $item, $wishlist );
							?>
							<?php if ( $show_add_to_cart && $item->is_purchasable() && 'out-of-stock' !== $item->get_stock_status() ) : ?>
								<?php woocommerce_template_loop_add_to_cart( array( 'quantity' => $show_quantity ? $item->get_quantity() : 1 ) ); ?>
							<?php endif ?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_product_after_add_to_cart
							 *
							 * Allows to render some content or fire some action after the 'Add to cart' in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_product_after_add_to_cart', $item, $wishlist );
							?>

							<!-- Change wishlist -->
							<?php
							/**
							 * APPLY_FILTERS: yith_wcwl_table_product_move_to_another_wishlist
							 *
							 * Filter if show the 'Move to another wishlist' button in the wishlist table for each product.
							 *
							 * @param bool                    $move_to_another_wishlist Show 'Move to another wishlist' button or not
							 * @param YITH_WCWL_Wishlist_Item $item                     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist                 Wishlist object
							 *
							 * @return bool
							 */
							$move_to_another_wishlist = apply_filters( 'yith_wcwl_table_product_move_to_another_wishlist', $move_to_another_wishlist, $item, $wishlist );
							?>
							<?php if ( $move_to_another_wishlist && $available_multi_wishlist && count( $users_wishlists ) > 1 ) : ?>
								<?php if ( 'select' === $move_to_another_wishlist_type ) : ?>
									<select class="change-wishlist selectBox">
										<option value=""><?php esc_html_e( 'Move', 'yith-woocommerce-wishlist' ); ?></option>
										<?php
										foreach ( $users_wishlists as $wl ) :
											/**
											 * Each of customer's wishlists
											 *
											 * @var $wl \YITH_WCWL_Wishlist
											 */
											if ( $wl->get_token() === $wishlist_token ) {
												continue;
											}
											?>
											<option value="<?php echo esc_attr( $wl->get_token() ); ?>">
												<?php printf( '%s - %s', esc_html( $wl->get_formatted_name() ), esc_html( $wl->get_formatted_privacy() ) ); ?>
											</option>
											<?php
										endforeach;
										?>
									</select>
								<?php else : ?>
									<a href="#move_to_another_wishlist" class="move-to-another-wishlist-button" data-rel="prettyPhoto[move_to_another_wishlist]">
										<?php
										/**
										 * APPLY_FILTERS: yith_wcwl_move_to_another_list_label
										 *
										 * Filter the label to move the product to another wishlist.
										 *
										 * @param string $label Label
										 *
										 * @return string
										 */
										echo esc_html( apply_filters( 'yith_wcwl_move_to_another_list_label', __( 'Move to another list &rsaquo;', 'yith-woocommerce-wishlist' ) ) );
										?>
									</a>
								<?php endif; ?>

								<?php
								/**
								 * DO_ACTION: yith_wcwl_table_product_after_move_to_another_wishlist
								 *
								 * Allows to render some content or fire some action after the 'Move to another wishlist' in the wishlist table.
								 *
								 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
								 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
								 */
								do_action( 'yith_wcwl_table_product_after_move_to_another_wishlist', $item, $wishlist );
								?>

							<?php endif; ?>

							<!-- Remove from wishlist -->
							<?php
							if ( $repeat_remove_button ) :
								/**
								 * APPLY_FILTERS: yith_wcwl_remove_product_wishlist_message_title
								 *
								 * Filter the title of the button to remove the product from the wishlist.
								 *
								 * @param string $title Button title
								 *
								 * @return string
								 */
								?>
								<a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove_from_wishlist button" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><?php esc_html_e( 'Remove', 'yith-woocommerce-wishlist' ); ?></a>
							<?php endif; ?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_cart
							 *
							 * Allows to render some content or fire some action after the product cart in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_cart', $item, $wishlist );
							?>
						</td>
					<?php endif; ?>

					<?php if ( $enable_drag_n_drop ) : ?>
						<td class="product-arrange ">
							<i class="fa fa-arrows"></i>
							<input type="hidden" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][position]" value="<?php echo esc_attr( $item->get_position() ); ?>"/>
						</td>
					<?php endif; ?>
				</tr>
				<?php
			endif;
		endforeach;
	else :
		?>
		<tr>
			<?php
			/**
			 * APPLY_FILTERS: yith_wcwl_no_product_to_remove_message
			 *
			 * Filter the message shown when there are no products in the wishlist.
			 *
			 * @param string             $message  Message
			 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
			 *
			 * @return string
			 */
			?>
			<td colspan="<?php echo esc_attr( $column_count ); ?>" class="wishlist-empty"><?php echo esc_html( apply_filters( 'yith_wcwl_no_product_to_remove_message', __( 'No products added to the wishlist', 'yith-woocommerce-wishlist' ), $wishlist ) ); ?></td>
		</tr>
		<?php
	endif;

	if ( ! empty( $page_links ) ) :
		?>
		<tr class="pagination-row wishlist-pagination">
			<td colspan="<?php echo esc_attr( $column_count ); ?>">
				<?php echo wp_kses_post( $page_links ); ?>
			</td>
		</tr>
	<?php endif ?>
	</tbody>

</table>
 <section class="catalog product_catalog favourites" id="favourites">
      <div class="cont">
        <div class="heading">
          <div class="left">
            <div class="line"></div>
            <h1>Избранные</h1>
          </div>
        </div>
        <div class="big-wrapper">
          <div class="sort">
            <div class="second">
				
              <div class="item">
<!--                 <a class="liked" href="#">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="16"
                    height="16"
                    viewBox="0 0 16 16"
                    fill="none"
                  >
                    <path
                      d="M11.125 1.75C9.86938 1.75 8.755 2.24563 8 3.0975C7.245 2.24563 6.13062 1.75 4.875 1.75C3.78139 1.75132 2.73295 2.18635 1.95965 2.95965C1.18635 3.73295 0.751323 4.78139 0.75 5.875C0.75 10.3962 7.36312 14.0088 7.64437 14.1606C7.75367 14.2195 7.87586 14.2503 8 14.2503C8.12414 14.2503 8.24633 14.2195 8.35563 14.1606C8.63688 14.0088 15.25 10.3962 15.25 5.875C15.2487 4.78139 14.8137 3.73295 14.0404 2.95965C13.2671 2.18635 12.2186 1.75132 11.125 1.75ZM10.7819 10.6475C9.91142 11.3861 8.98091 12.0509 8 12.635C7.01909 12.0509 6.08858 11.3861 5.21812 10.6475C3.86375 9.48563 2.25 7.71375 2.25 5.875C2.25 5.17881 2.52656 4.51113 3.01884 4.01884C3.51113 3.52656 4.17881 3.25 4.875 3.25C5.9875 3.25 6.91875 3.8375 7.30562 4.78375C7.36193 4.92169 7.45805 5.03974 7.58172 5.12283C7.70539 5.20592 7.85101 5.2503 8 5.2503C8.14899 5.2503 8.29461 5.20592 8.41828 5.12283C8.54195 5.03974 8.63807 4.92169 8.69438 4.78375C9.08125 3.8375 10.0125 3.25 11.125 3.25C11.8212 3.25 12.4889 3.52656 12.9812 4.01884C13.4734 4.51113 13.75 5.17881 13.75 5.875C13.75 7.71375 12.1362 9.48563 10.7819 10.6475Z"
                      fill="white"
                    />
                  </svg>
                </a> -->
                <div class="img-wrapper">
                  <div
                    class="swiper swiper-grid swiper-1 swiper-initialized swiper-horizontal swiper-backface-hidden"
                    data-id="1"
                  >
                    <div
                      class="swiper-wrapper"
                      id="swiper-wrapper-7fb6b3c349c727f2"
                      aria-live="polite"
                      style="cursor: grab"
                    >
                      <div
                        class="swiper-slide swiper-slide-active"
                        role="group"
                        aria-label="1 / 3"
                        style="width: 306px"
                      >
                    
	
                      </div>
                      
                    </div>
                    <span
                      class="swiper-notification"
                      aria-live="assertive"
                      aria-atomic="true"
                    ></span>
                  </div>
                  <div
                    class="swiper-pagination swiper-pagination-1 swiper-pagination-bullets swiper-pagination-horizontal"
                  >
                    <span
                      class="swiper-pagination-bullet swiper-pagination-bullet-active"
                      aria-current="true"
                    ></span
                    ><span class="swiper-pagination-bullet"></span
                    ><span class="swiper-pagination-bullet"></span>
                  </div>
                </div>
                <div class="info-item">
                  <a href="#"><h3>Название модели стула</h3></a>
                  <div class="price">
                    <h2>100 000 тг</h2>
                    <a class="custom-btn hidden-btn" href="#">Оформить заказ</a>
                  </div>
                </div>
              </div>
			

            </div>
          </div>
        </div>
      </div>
    </section>














	<table
	class="shop_table cart wishlist_table wishlist_view traditional responsive <?php echo $no_interactions ? 'no-interactions' : ''; ?> <?php echo $enable_drag_n_drop ? 'sortable' : ''; ?> "
	data-pagination="<?php echo esc_attr( $pagination ); ?>" data-per-page="<?php echo esc_attr( $per_page ); ?>" data-page="<?php echo esc_attr( $current_page ); ?>"
	data-id="<?php echo esc_attr( $wishlist_id ); ?>" data-token="<?php echo esc_attr( $wishlist_token ); ?>">

	<?php $column_count = 2; ?>

	<thead class="d-none">
	<tr>
		<?php if ( $show_cb ) : ?>
			<?php ++$column_count; ?>
			<th class="product-checkbox">
				<input type="checkbox" value="" name="" id="bulk_add_to_cart"/>
			</th>
		<?php endif; ?>

		<?php if ( $show_remove_product ) : ?>
			<?php ++$column_count; ?>
			<th class="product-remove">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_remove_heading
					 *
					 * Filter the heading of the column to remove the product from the wishlist in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_remove_heading', '', $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<th class="product-thumbnail"></th>

		<th class="product-name">
			<span class="nobr">
				<?php
				/**
				 * APPLY_FILTERS: yith_wcwl_wishlist_view_name_heading
				 *
				 * Filter the heading of the column to show the product name in the wishlist table.
				 *
				 * @param string             $heading  Heading text
				 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
				 *
				 * @return string
				 */
				echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_name_heading', __( 'Product name', 'yith-woocommerce-wishlist' ), $wishlist ) );
				?>
			</span>
		</th>

		<?php if ( $show_price || $show_price_variations ) : ?>
			<?php ++$column_count; ?>
			<th class="product-price">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_price_heading
					 *
					 * Filter the heading of the column to show the product price in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_price_heading', __( 'Unit price', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $show_quantity ) : ?>
			<?php ++$column_count; ?>
			<th class="product-quantity">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_quantity_heading
					 *
					 * Filter the heading of the column to show the product quantity in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_quantity_heading', __( 'Quantity', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $show_stock_status ) : ?>
			<?php ++$column_count; ?>
			<th class="product-stock-status">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_stock_heading
					 *
					 * Filter the heading of the column to show the product stock status in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_stock_heading', __( 'Stock status', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $show_last_column ) : ?>
			<?php ++$column_count; ?>
			<th class="product-add-to-cart">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_cart_heading
					 *
					 * Filter the heading of the cart column in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_cart_heading', '', $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>

		<?php if ( $enable_drag_n_drop ) : ?>
			<?php ++$column_count; ?>
			<th class="product-arrange">
				<span class="nobr">
					<?php
					/**
					 * APPLY_FILTERS: yith_wcwl_wishlist_view_arrange_heading
					 *
					 * Filter the heading of the column to change order of the items in the wishlist table.
					 *
					 * @param string             $heading  Heading text
					 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
					 *
					 * @return string
					 */
					echo esc_html( apply_filters( 'yith_wcwl_wishlist_view_arrange_heading', __( 'Arrange', 'yith-woocommerce-wishlist' ), $wishlist ) );
					?>
				</span>
			</th>
		<?php endif; ?>
	</tr>
	</thead>

	<tbody class="wishlist-items-wrapper">
	<?php
	if ( $wishlist && $wishlist->has_items() ) :
		foreach ( $wishlist_items as $item ) :
			/**
			 * Each of the wishlist items
			 *
			 * @var $item \YITH_WCWL_Wishlist_Item
			 */
			global $product;

			$product = $item->get_product();

			if ( $product && $product->exists() ) :
				?>
				<tr id="yith-wcwl-row-<?php echo esc_attr( $item->get_product_id() ); ?>" data-row-id="<?php echo esc_attr( $item->get_product_id() ); ?>">
					<?php if ( $show_cb ) : ?>
						<td class="product-checkbox">
							<input type="checkbox" value="yes" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][cb]"/>
						</td>
					<?php endif ?>

					<?php if ( $show_remove_product ) : ?>
						<td class="product-remove">
							<div>
								<?php
								/**
								 * APPLY_FILTERS: yith_wcwl_remove_product_wishlist_message_title
								 *
								 * Filter the title of the icon to remove the product from the wishlist.
								 *
								 * @param string $title Icon title
								 *
								 * @return string
								 */
								?>
								<a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove remove_from_wishlist" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>">&times;</a>
							</div>
						</td>
					<?php endif; ?>

					<td class="product-thumbnail">
						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_before_product_thumbnail
						 *
						 * Allows to render some content or fire some action before the product thumbnail in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_before_product_thumbnail', $item, $wishlist );
						?>

						<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
							<?php echo wp_kses_post( $product->get_image() ); ?>
						</a>

						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_after_product_thumbnail
						 *
						 * Allows to render some content or fire some action after the product thumbnail in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_after_product_thumbnail', $item, $wishlist );
						?>
					</td>

					<td class="product-name">
						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_before_product_name
						 *
						 * Allows to render some content or fire some action before the product name in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_before_product_name', $item, $wishlist );
						?>

						<a href="<?php echo esc_url( get_permalink( apply_filters( 'woocommerce_in_cart_product', $item->get_product_id() ) ) ); ?>">
							<?php echo wp_kses_post( apply_filters( 'woocommerce_in_cartproduct_obj_title', $product->get_title(), $product ) ); ?>
						</a>

						<?php
						if ( $show_variation && $product->is_type( 'variation' ) ) {
							/**
							 * Product is a Variation
							 *
							 * @var $product \WC_Product_Variation
							 */
							echo wp_kses_post( wc_get_formatted_variation( $product ) );
						}
						?>

						<?php
						/**
						 * DO_ACTION: yith_wcwl_table_after_product_name
						 *
						 * Allows to render some content or fire some action after the product name in the wishlist table.
						 *
						 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
						 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
						 */
						do_action( 'yith_wcwl_table_after_product_name', $item, $wishlist );
						?>
					</td>

					<?php if ( $show_price || $show_price_variations ) : ?>
						<td class="product-price">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_price
							 *
							 * Allows to render some content or fire some action before the product price in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_price', $item, $wishlist );
							?>

							<?php
							if ( $show_price ) {
								echo wp_kses_post( $item->get_formatted_product_price() );
							}

							if ( $show_price_variations ) {
								echo wp_kses_post( $item->get_price_variation() );
							}
							?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_price
							 *
							 * Allows to render some content or fire some action after the product price in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_price', $item, $wishlist );
							?>
						</td>
					<?php endif ?>

					<?php if ( $show_quantity ) : ?>
						<td class="product-quantity">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_quantity
							 *
							 * Allows to render some content or fire some action before the product quantity in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_quantity', $item, $wishlist );
							?>

							<?php if ( ! $no_interactions && $wishlist->current_user_can( 'update_quantity' ) ) : ?>
								<input type="number" min="1" step="1" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][quantity]" value="<?php echo esc_attr( $item->get_quantity() ); ?>"/>
							<?php else : ?>
								<?php echo esc_html( $item->get_quantity() ); ?>
							<?php endif; ?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_quantity
							 *
							 * Allows to render some content or fire some action after the product quantity in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_quantity', $item, $wishlist );
							?>
						</td>
					<?php endif; ?>

					<?php if ( $show_stock_status ) : ?>
						<td class="product-stock-status">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_stock
							 *
							 * Allows to render some content or fire some action before the product stock in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_stock', $item, $wishlist );
							?>

							<?php
							/**
							 * APPLY_FILTERS: yith_wcwl_out_of_stock_label
							 *
							 * Filter the label when the product in the wishlist is out of stock.
							 *
							 * @param string $label Label
							 *
							 * @return string
							 */
							/**
							 * APPLY_FILTERS: yith_wcwl_in_stock_label
							 *
							 * Filter the label when the product in the wishlist is in stock.
							 *
							 * @param string $label Label
							 *
							 * @return string
							 */
							$stock_status_html = 'out-of-stock' === $item->get_stock_status() ? '<span class="wishlist-out-of-stock">' . esc_html( apply_filters( 'yith_wcwl_out_of_stock_label', __( 'Out of stock', 'yith-woocommerce-wishlist' ) ) ) . '</span>' : '<span class="wishlist-in-stock">' . esc_html( apply_filters( 'yith_wcwl_in_stock_label', __( 'In Stock', 'yith-woocommerce-wishlist' ) ) ) . '</span>';

							/**
							 * APPLY_FILTERS: yith_wcwl_stock_status
							 *
							 * Filters the HTML for the stock status label.
							 *
							 * @param string                  $stock_status_html Stock status HTML.
							 * @param YITH_WCWL_Wishlist_Item $item              Wishlist item object.
							 * @param YITH_WCWL_Wishlist      $wishlist          Wishlist object.
							 *
							 * @return string
							 */
							echo wp_kses_post( apply_filters( 'yith_wcwl_stock_status', $stock_status_html, $item, $wishlist ) );
							?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_stock
							 *
							 * Allows to render some content or fire some action after the product stock in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_stock', $item, $wishlist );
							?>
						</td>
					<?php endif ?>

					<?php if ( $show_last_column ) : ?>
						<td class="product-add-to-cart">
							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_before_product_cart
							 *
							 * Allows to render some content or fire some action before the product cart in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_before_product_cart', $item, $wishlist );
							?>

							<!-- Date added -->
							<?php
							if ( $show_dateadded && $item->get_date_added() ) :
								// translators: date added label: 1 date added.
								echo '<span class="dateadded">' . esc_html( sprintf( __( 'Added on: %s', 'yith-woocommerce-wishlist' ), $item->get_date_added_formatted() ) ) . '</span>';
							endif;
							?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_product_before_add_to_cart
							 *
							 * Allows to render some content or fire some action before the 'Add to cart' in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_product_before_add_to_cart', $item, $wishlist );
							?>

							<!-- Add to cart button -->
							<?php
							/**
							 * APPLY_FILTERS: yith_wcwl_table_product_show_add_to_cart
							 *
							 * Filter if show the 'Add to cart' button in the wishlist table for each product.
							 *
							 * @param bool                    $show_add_to_cart Show 'Add to cart' button or not
							 * @param YITH_WCWL_Wishlist_Item $item             Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist         Wishlist object
							 *
							 * @return bool
							 */
							$show_add_to_cart = apply_filters( 'yith_wcwl_table_product_show_add_to_cart', $show_add_to_cart, $item, $wishlist );
							?>
							<?php if ( $show_add_to_cart && $item->is_purchasable() && 'out-of-stock' !== $item->get_stock_status() ) : ?>
								<?php woocommerce_template_loop_add_to_cart( array( 'quantity' => $show_quantity ? $item->get_quantity() : 1 ) ); ?>
							<?php endif ?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_product_after_add_to_cart
							 *
							 * Allows to render some content or fire some action after the 'Add to cart' in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_product_after_add_to_cart', $item, $wishlist );
							?>

							<!-- Change wishlist -->
							<?php
							/**
							 * APPLY_FILTERS: yith_wcwl_table_product_move_to_another_wishlist
							 *
							 * Filter if show the 'Move to another wishlist' button in the wishlist table for each product.
							 *
							 * @param bool                    $move_to_another_wishlist Show 'Move to another wishlist' button or not
							 * @param YITH_WCWL_Wishlist_Item $item                     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist                 Wishlist object
							 *
							 * @return bool
							 */
							$move_to_another_wishlist = apply_filters( 'yith_wcwl_table_product_move_to_another_wishlist', $move_to_another_wishlist, $item, $wishlist );
							?>
							<?php if ( $move_to_another_wishlist && $available_multi_wishlist && count( $users_wishlists ) > 1 ) : ?>
								<?php if ( 'select' === $move_to_another_wishlist_type ) : ?>
									<select class="change-wishlist selectBox">
										<option value=""><?php esc_html_e( 'Move', 'yith-woocommerce-wishlist' ); ?></option>
										<?php
										foreach ( $users_wishlists as $wl ) :
											/**
											 * Each of customer's wishlists
											 *
											 * @var $wl \YITH_WCWL_Wishlist
											 */
											if ( $wl->get_token() === $wishlist_token ) {
												continue;
											}
											?>
											<option value="<?php echo esc_attr( $wl->get_token() ); ?>">
												<?php printf( '%s - %s', esc_html( $wl->get_formatted_name() ), esc_html( $wl->get_formatted_privacy() ) ); ?>
											</option>
											<?php
										endforeach;
										?>
									</select>
								<?php else : ?>
									<a href="#move_to_another_wishlist" class="move-to-another-wishlist-button" data-rel="prettyPhoto[move_to_another_wishlist]">
										<?php
										/**
										 * APPLY_FILTERS: yith_wcwl_move_to_another_list_label
										 *
										 * Filter the label to move the product to another wishlist.
										 *
										 * @param string $label Label
										 *
										 * @return string
										 */
										echo esc_html( apply_filters( 'yith_wcwl_move_to_another_list_label', __( 'Move to another list &rsaquo;', 'yith-woocommerce-wishlist' ) ) );
										?>
									</a>
								<?php endif; ?>

								<?php
								/**
								 * DO_ACTION: yith_wcwl_table_product_after_move_to_another_wishlist
								 *
								 * Allows to render some content or fire some action after the 'Move to another wishlist' in the wishlist table.
								 *
								 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
								 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
								 */
								do_action( 'yith_wcwl_table_product_after_move_to_another_wishlist', $item, $wishlist );
								?>

							<?php endif; ?>

							<!-- Remove from wishlist -->
							<?php
							if ( $repeat_remove_button ) :
								/**
								 * APPLY_FILTERS: yith_wcwl_remove_product_wishlist_message_title
								 *
								 * Filter the title of the button to remove the product from the wishlist.
								 *
								 * @param string $title Button title
								 *
								 * @return string
								 */
								?>
								<a href="<?php echo esc_url( $item->get_remove_url() ); ?>" class="remove_from_wishlist button" title="<?php echo esc_html( apply_filters( 'yith_wcwl_remove_product_wishlist_message_title', __( 'Remove this product', 'yith-woocommerce-wishlist' ) ) ); ?>"><?php esc_html_e( 'Remove', 'yith-woocommerce-wishlist' ); ?></a>
							<?php endif; ?>

							<?php
							/**
							 * DO_ACTION: yith_wcwl_table_after_product_cart
							 *
							 * Allows to render some content or fire some action after the product cart in the wishlist table.
							 *
							 * @param YITH_WCWL_Wishlist_Item $item     Wishlist item object
							 * @param YITH_WCWL_Wishlist      $wishlist Wishlist object
							 */
							do_action( 'yith_wcwl_table_after_product_cart', $item, $wishlist );
							?>
						</td>
					<?php endif; ?>

					<?php if ( $enable_drag_n_drop ) : ?>
						<td class="product-arrange ">
							<i class="fa fa-arrows"></i>
							<input type="hidden" name="items[<?php echo esc_attr( $item->get_product_id() ); ?>][position]" value="<?php echo esc_attr( $item->get_position() ); ?>"/>
						</td>
					<?php endif; ?>
				</tr>
				<?php
			endif;
		endforeach;
	else :
		?>
		<tr>
			<?php
			/**
			 * APPLY_FILTERS: yith_wcwl_no_product_to_remove_message
			 *
			 * Filter the message shown when there are no products in the wishlist.
			 *
			 * @param string             $message  Message
			 * @param YITH_WCWL_Wishlist $wishlist Wishlist object
			 *
			 * @return string
			 */
			?>
			<td colspan="<?php echo esc_attr( $column_count ); ?>" class="wishlist-empty"><?php echo esc_html( apply_filters( 'yith_wcwl_no_product_to_remove_message', __( 'No products added to the wishlist', 'yith-woocommerce-wishlist' ), $wishlist ) ); ?></td>
		</tr>
		<?php
	endif;

	if ( ! empty( $page_links ) ) :
		?>
		<tr class="pagination-row wishlist-pagination">
			<td colspan="<?php echo esc_attr( $column_count ); ?>">
				<?php echo wp_kses_post( $page_links ); ?>
			</td>
		</tr>
	<?php endif ?>
	</tbody>

</table>