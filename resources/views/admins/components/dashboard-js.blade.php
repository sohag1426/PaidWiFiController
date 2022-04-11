<script>
    $(document).ready(function () {

        $.get( "/widgets/will_be_suspended", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#will_be_suspended').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#will_be_suspended').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/amount_to_be_collected", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#amount_to_be_collected').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#amount_to_be_collected').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/collected_amount", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#collected_amount').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#collected_amount').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/online_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#online_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#online_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/active_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#active_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#active_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/suspend_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#suspended_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#suspended_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/disabled_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#disabled_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#disabled_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/new_registration_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#user_registrations').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#user_registrations').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/billed_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#billed_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#billed_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/paid_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#paid_customers').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#paid_customers').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/total_customer_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#total_customer').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#total_customer').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/amount_paid_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#amount_paid').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#amount_paid').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/amount_due_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#amount_due').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#amount_due').text(this.countNum);
                }
            });
        });

        $.get( "/widgets/sms_widget", function( data ) {
            $({countNum: 0}).animate({
                countNum: data
            }, {
                duration: 500,
                easing:'linear',
                step: function() {
                    $('#sms_sent').text(Math.floor(this.countNum));
                },
                complete: function() {
                    $('#sms_sent').text(this.countNum);
                }
            });
        });

    });

</script>
