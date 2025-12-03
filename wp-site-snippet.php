<?php
add_action("woocommerce_checkout_order_processed", "send_order_to_webhook", 10, 1);
function send_order_to_webhook($order_id) {

    $order = wc_get_order($order_id);

    $data = array(
        "id"     => $order->get_id(),
        "total"  => $order->get_total(),
        "billing" => array(
            "first_name" => $order->get_meta('gonderen_isim'),
            "phone" => $order->get_meta('gonderen_telefon'),
        ),
    );

    wp_remote_post("https://your-cloud-run-url/order_notification/", array(
        "method"  => "POST",
        "headers" => array("Content-Type" => "application/json"),
        "body"    => wp_json_encode($data),
        "timeout" => 60,
    ));
}
