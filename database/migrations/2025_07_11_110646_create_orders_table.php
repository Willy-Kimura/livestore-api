<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /**
         * Appendix:
         *
         * Order Status Options
         * ********************
         * Open: The order has been placed and is being processed.
         * Archived: The order has been completed or canceled and is no longer actively being worked on.
         * Canceled: The order has been canceled and is not being fulfilled.
         * Completed: The order has been successfully fulfilled and delivered.
         *
         * Payment Status Options
         * **********************
         * Pending: The order has been created but not yet paid.
         * Paid: The customer has submitted payment, and the order is awaiting fulfillment.
         * Refunded: The customer has received a refund for the order.
         *
         * Fulfilment Status Options
         * **************************
         * Pending: The order is awaiting processing.
         * Processing: The order is being prepared for shipment.
         * Shipped: The order has been shipped and is on its way to the customer.
         * Out for Delivery: The order is currently being delivered.
         * Delivered: The order has been successfully delivered to the customer.
         * Partially Fulfilled: Only some items in the order have been shipped.
         *
         * Return Status Options
         * *********************
         * Return Requested: The customer has initiated a return request.
         * Return Approved: The return request has been approved.
         * Return Shipped: The customer has shipped the returned items.
         * Returned: The returned items have been received by the seller.
         */

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable();
            $table->string('opt_first_name')->nullable();
            $table->string('opt_middle_name')->nullable();
            $table->string('opt_last_name')->nullable();
            $table->string('opt_phone')->nullable();
            $table->string('opt_email')->nullable();
            $table->decimal('subtotal', places:2)->nullable();
            $table->decimal('total', places:2)->nullable();
            $table->text('delivery_address')->nullable();
            $table->text('delivery_location')->nullable();
            $table->text('delivery_instructions')->nullable();
            $table->string('payment_mode')->nullable();
            $table->enum('order_status', ['Open', 'Completed', 'Cancelled', 'Archived'])->nullable();
            $table->enum('payment_status', ['Pending', 'Paid', 'Refunded'])->nullable();
            $table->enum('fulfilment_status', ['Pending', 'Processing', 'Shipped', 'Out for Delivery', 'Delivered', 'Partially Fulfilled'])->nullable();
            $table->enum('return_status', ['Return Requested', 'Return Approved', 'Return Shipped', 'Returned'])->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
