<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection time
     * @property Grid\Column|Collection cycle
     * @property Grid\Column|Collection price
     * @property Grid\Column|Collection setup_fee
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection display
     * @property Grid\Column|Collection buy
     * @property Grid\Column|Collection renew
     * @property Grid\Column|Collection postpaid
     * @property Grid\Column|Collection auto_generate
     * @property Grid\Column|Collection remark
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection sale
     * @property Grid\Column|Collection deleted_at
     * @property Grid\Column|Collection level
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection no
     * @property Grid\Column|Collection serial_number
     * @property Grid\Column|Collection total_price
     * @property Grid\Column|Collection marketing_costs
     * @property Grid\Column|Collection commission_charge
     * @property Grid\Column|Collection amount
     * @property Grid\Column|Collection refund
     * @property Grid\Column|Collection payment
     * @property Grid\Column|Collection account
     * @property Grid\Column|Collection unit
     * @property Grid\Column|Collection sub_status
     * @property Grid\Column|Collection expired_at
     * @property Grid\Column|Collection payment_at
     * @property Grid\Column|Collection invoice_no
     * @property Grid\Column|Collection unit_price
     * @property Grid\Column|Collection tax
     * @property Grid\Column|Collection sale_name
     * @property Grid\Column|Collection link
     * @property Grid\Column|Collection quantity
     * @property Grid\Column|Collection service_id
     * @property Grid\Column|Collection billing_id
     * @property Grid\Column|Collection time_quantity
     * @property Grid\Column|Collection read
     * @property Grid\Column|Collection content
     * @property Grid\Column|Collection notice_method
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection class
     * @property Grid\Column|Collection key
     * @property Grid\Column|Collection author
     * @property Grid\Column|Collection stock
     * @property Grid\Column|Collection max
     * @property Grid\Column|Collection review
     * @property Grid\Column|Collection cost
     * @property Grid\Column|Collection gross_margin
     * @property Grid\Column|Collection category_id
     * @property Grid\Column|Collection subtitle
     * @property Grid\Column|Collection product_id
     * @property Grid\Column|Collection user_config
     * @property Grid\Column|Collection auto_renew
     * @property Grid\Column|Collection ip_address
     * @property Grid\Column|Collection user_agent
     * @property Grid\Column|Collection last_activity
     * @property Grid\Column|Collection personal_team
     * @property Grid\Column|Collection team_id
     * @property Grid\Column|Collection role
     * @property Grid\Column|Collection contact
     * @property Grid\Column|Collection priority
     * @property Grid\Column|Collection user_uuid
     * @property Grid\Column|Collection service_uuid
     * @property Grid\Column|Collection admin_id
     * @property Grid\Column|Collection admin
     * @property Grid\Column|Collection ticket_id
     * @property Grid\Column|Collection confidential
     * @property Grid\Column|Collection phone
     * @property Grid\Column|Collection email_verified_at
     * @property Grid\Column|Collection phone_verified_at
     * @property Grid\Column|Collection two_factor_secret
     * @property Grid\Column|Collection two_factor_recovery_codes
     * @property Grid\Column|Collection current_team_id
     * @property Grid\Column|Collection profile_photo_path
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection time(string $label = null)
     * @method Grid\Column|Collection cycle(string $label = null)
     * @method Grid\Column|Collection price(string $label = null)
     * @method Grid\Column|Collection setup_fee(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection display(string $label = null)
     * @method Grid\Column|Collection buy(string $label = null)
     * @method Grid\Column|Collection renew(string $label = null)
     * @method Grid\Column|Collection postpaid(string $label = null)
     * @method Grid\Column|Collection auto_generate(string $label = null)
     * @method Grid\Column|Collection remark(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection sale(string $label = null)
     * @method Grid\Column|Collection deleted_at(string $label = null)
     * @method Grid\Column|Collection level(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection no(string $label = null)
     * @method Grid\Column|Collection serial_number(string $label = null)
     * @method Grid\Column|Collection total_price(string $label = null)
     * @method Grid\Column|Collection marketing_costs(string $label = null)
     * @method Grid\Column|Collection commission_charge(string $label = null)
     * @method Grid\Column|Collection amount(string $label = null)
     * @method Grid\Column|Collection refund(string $label = null)
     * @method Grid\Column|Collection payment(string $label = null)
     * @method Grid\Column|Collection account(string $label = null)
     * @method Grid\Column|Collection unit(string $label = null)
     * @method Grid\Column|Collection sub_status(string $label = null)
     * @method Grid\Column|Collection expired_at(string $label = null)
     * @method Grid\Column|Collection payment_at(string $label = null)
     * @method Grid\Column|Collection invoice_no(string $label = null)
     * @method Grid\Column|Collection unit_price(string $label = null)
     * @method Grid\Column|Collection tax(string $label = null)
     * @method Grid\Column|Collection sale_name(string $label = null)
     * @method Grid\Column|Collection link(string $label = null)
     * @method Grid\Column|Collection quantity(string $label = null)
     * @method Grid\Column|Collection service_id(string $label = null)
     * @method Grid\Column|Collection billing_id(string $label = null)
     * @method Grid\Column|Collection time_quantity(string $label = null)
     * @method Grid\Column|Collection read(string $label = null)
     * @method Grid\Column|Collection content(string $label = null)
     * @method Grid\Column|Collection notice_method(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection class(string $label = null)
     * @method Grid\Column|Collection key(string $label = null)
     * @method Grid\Column|Collection author(string $label = null)
     * @method Grid\Column|Collection stock(string $label = null)
     * @method Grid\Column|Collection max(string $label = null)
     * @method Grid\Column|Collection review(string $label = null)
     * @method Grid\Column|Collection cost(string $label = null)
     * @method Grid\Column|Collection gross_margin(string $label = null)
     * @method Grid\Column|Collection category_id(string $label = null)
     * @method Grid\Column|Collection subtitle(string $label = null)
     * @method Grid\Column|Collection product_id(string $label = null)
     * @method Grid\Column|Collection user_config(string $label = null)
     * @method Grid\Column|Collection auto_renew(string $label = null)
     * @method Grid\Column|Collection ip_address(string $label = null)
     * @method Grid\Column|Collection user_agent(string $label = null)
     * @method Grid\Column|Collection last_activity(string $label = null)
     * @method Grid\Column|Collection personal_team(string $label = null)
     * @method Grid\Column|Collection team_id(string $label = null)
     * @method Grid\Column|Collection role(string $label = null)
     * @method Grid\Column|Collection contact(string $label = null)
     * @method Grid\Column|Collection priority(string $label = null)
     * @method Grid\Column|Collection user_uuid(string $label = null)
     * @method Grid\Column|Collection service_uuid(string $label = null)
     * @method Grid\Column|Collection admin_id(string $label = null)
     * @method Grid\Column|Collection admin(string $label = null)
     * @method Grid\Column|Collection ticket_id(string $label = null)
     * @method Grid\Column|Collection confidential(string $label = null)
     * @method Grid\Column|Collection phone(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     * @method Grid\Column|Collection phone_verified_at(string $label = null)
     * @method Grid\Column|Collection two_factor_secret(string $label = null)
     * @method Grid\Column|Collection two_factor_recovery_codes(string $label = null)
     * @method Grid\Column|Collection current_team_id(string $label = null)
     * @method Grid\Column|Collection profile_photo_path(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection type
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection time
     * @property Show\Field|Collection cycle
     * @property Show\Field|Collection price
     * @property Show\Field|Collection setup_fee
     * @property Show\Field|Collection status
     * @property Show\Field|Collection display
     * @property Show\Field|Collection buy
     * @property Show\Field|Collection renew
     * @property Show\Field|Collection postpaid
     * @property Show\Field|Collection auto_generate
     * @property Show\Field|Collection remark
     * @property Show\Field|Collection config
     * @property Show\Field|Collection sale
     * @property Show\Field|Collection deleted_at
     * @property Show\Field|Collection level
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection no
     * @property Show\Field|Collection serial_number
     * @property Show\Field|Collection total_price
     * @property Show\Field|Collection marketing_costs
     * @property Show\Field|Collection commission_charge
     * @property Show\Field|Collection amount
     * @property Show\Field|Collection refund
     * @property Show\Field|Collection payment
     * @property Show\Field|Collection account
     * @property Show\Field|Collection unit
     * @property Show\Field|Collection sub_status
     * @property Show\Field|Collection expired_at
     * @property Show\Field|Collection payment_at
     * @property Show\Field|Collection invoice_no
     * @property Show\Field|Collection unit_price
     * @property Show\Field|Collection tax
     * @property Show\Field|Collection sale_name
     * @property Show\Field|Collection link
     * @property Show\Field|Collection quantity
     * @property Show\Field|Collection service_id
     * @property Show\Field|Collection billing_id
     * @property Show\Field|Collection time_quantity
     * @property Show\Field|Collection read
     * @property Show\Field|Collection content
     * @property Show\Field|Collection notice_method
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection class
     * @property Show\Field|Collection key
     * @property Show\Field|Collection author
     * @property Show\Field|Collection stock
     * @property Show\Field|Collection max
     * @property Show\Field|Collection review
     * @property Show\Field|Collection cost
     * @property Show\Field|Collection gross_margin
     * @property Show\Field|Collection category_id
     * @property Show\Field|Collection subtitle
     * @property Show\Field|Collection product_id
     * @property Show\Field|Collection user_config
     * @property Show\Field|Collection auto_renew
     * @property Show\Field|Collection ip_address
     * @property Show\Field|Collection user_agent
     * @property Show\Field|Collection last_activity
     * @property Show\Field|Collection personal_team
     * @property Show\Field|Collection team_id
     * @property Show\Field|Collection role
     * @property Show\Field|Collection contact
     * @property Show\Field|Collection priority
     * @property Show\Field|Collection user_uuid
     * @property Show\Field|Collection service_uuid
     * @property Show\Field|Collection admin_id
     * @property Show\Field|Collection admin
     * @property Show\Field|Collection ticket_id
     * @property Show\Field|Collection confidential
     * @property Show\Field|Collection phone
     * @property Show\Field|Collection email_verified_at
     * @property Show\Field|Collection phone_verified_at
     * @property Show\Field|Collection two_factor_secret
     * @property Show\Field|Collection two_factor_recovery_codes
     * @property Show\Field|Collection current_team_id
     * @property Show\Field|Collection profile_photo_path
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection time(string $label = null)
     * @method Show\Field|Collection cycle(string $label = null)
     * @method Show\Field|Collection price(string $label = null)
     * @method Show\Field|Collection setup_fee(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection display(string $label = null)
     * @method Show\Field|Collection buy(string $label = null)
     * @method Show\Field|Collection renew(string $label = null)
     * @method Show\Field|Collection postpaid(string $label = null)
     * @method Show\Field|Collection auto_generate(string $label = null)
     * @method Show\Field|Collection remark(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection sale(string $label = null)
     * @method Show\Field|Collection deleted_at(string $label = null)
     * @method Show\Field|Collection level(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection no(string $label = null)
     * @method Show\Field|Collection serial_number(string $label = null)
     * @method Show\Field|Collection total_price(string $label = null)
     * @method Show\Field|Collection marketing_costs(string $label = null)
     * @method Show\Field|Collection commission_charge(string $label = null)
     * @method Show\Field|Collection amount(string $label = null)
     * @method Show\Field|Collection refund(string $label = null)
     * @method Show\Field|Collection payment(string $label = null)
     * @method Show\Field|Collection account(string $label = null)
     * @method Show\Field|Collection unit(string $label = null)
     * @method Show\Field|Collection sub_status(string $label = null)
     * @method Show\Field|Collection expired_at(string $label = null)
     * @method Show\Field|Collection payment_at(string $label = null)
     * @method Show\Field|Collection invoice_no(string $label = null)
     * @method Show\Field|Collection unit_price(string $label = null)
     * @method Show\Field|Collection tax(string $label = null)
     * @method Show\Field|Collection sale_name(string $label = null)
     * @method Show\Field|Collection link(string $label = null)
     * @method Show\Field|Collection quantity(string $label = null)
     * @method Show\Field|Collection service_id(string $label = null)
     * @method Show\Field|Collection billing_id(string $label = null)
     * @method Show\Field|Collection time_quantity(string $label = null)
     * @method Show\Field|Collection read(string $label = null)
     * @method Show\Field|Collection content(string $label = null)
     * @method Show\Field|Collection notice_method(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection class(string $label = null)
     * @method Show\Field|Collection key(string $label = null)
     * @method Show\Field|Collection author(string $label = null)
     * @method Show\Field|Collection stock(string $label = null)
     * @method Show\Field|Collection max(string $label = null)
     * @method Show\Field|Collection review(string $label = null)
     * @method Show\Field|Collection cost(string $label = null)
     * @method Show\Field|Collection gross_margin(string $label = null)
     * @method Show\Field|Collection category_id(string $label = null)
     * @method Show\Field|Collection subtitle(string $label = null)
     * @method Show\Field|Collection product_id(string $label = null)
     * @method Show\Field|Collection user_config(string $label = null)
     * @method Show\Field|Collection auto_renew(string $label = null)
     * @method Show\Field|Collection ip_address(string $label = null)
     * @method Show\Field|Collection user_agent(string $label = null)
     * @method Show\Field|Collection last_activity(string $label = null)
     * @method Show\Field|Collection personal_team(string $label = null)
     * @method Show\Field|Collection team_id(string $label = null)
     * @method Show\Field|Collection role(string $label = null)
     * @method Show\Field|Collection contact(string $label = null)
     * @method Show\Field|Collection priority(string $label = null)
     * @method Show\Field|Collection user_uuid(string $label = null)
     * @method Show\Field|Collection service_uuid(string $label = null)
     * @method Show\Field|Collection admin_id(string $label = null)
     * @method Show\Field|Collection admin(string $label = null)
     * @method Show\Field|Collection ticket_id(string $label = null)
     * @method Show\Field|Collection confidential(string $label = null)
     * @method Show\Field|Collection phone(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     * @method Show\Field|Collection phone_verified_at(string $label = null)
     * @method Show\Field|Collection two_factor_secret(string $label = null)
     * @method Show\Field|Collection two_factor_recovery_codes(string $label = null)
     * @method Show\Field|Collection current_team_id(string $label = null)
     * @method Show\Field|Collection profile_photo_path(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
