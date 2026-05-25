{$meta_title = 'Прибуток та витрати' scope=global}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">
                Прибуток та витрати
            </div>
            <div class="box_btn_heading">
                <a class="export_block export_users hint-bottom-middle-t-info-s-small-mobile  hint-anim" data-hint="Налаштування категорій витрат" href="{url controller=[SoloDevStyle,CostPrice,ExpensesCategoriesAdmin] return=$smarty.server.REQUEST_URI}">
                    <svg width="20" height="20" viewBox="0 0 19 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.72 13.252c.579 0 1.12-.149 1.626-.446a3.364 3.364 0 0 0 1.202-1.191A3.095 3.095 0 0 0 12.994 10c0-.58-.149-1.121-.446-1.626a3.336 3.336 0 0 0-1.202-1.203 3.153 3.153 0 0 0-1.626-.445c-.58 0-1.118.148-1.615.445a3.364 3.364 0 0 0-1.192 1.203A3.153 3.153 0 0 0 6.468 10c0 .58.148 1.117.445 1.615.297.497.694.894 1.192 1.191a3.095 3.095 0 0 0 1.615.446zm6.927-2.339l1.937 1.515c.09.074.141.17.156.29a.525.525 0 0 1-.067.333l-1.87 3.208a.407.407 0 0 1-.234.2.493.493 0 0 1-.323-.022l-2.294-.913c-.594.43-1.122.735-1.582.913l-.334 2.428a.566.566 0 0 1-.167.29.403.403 0 0 1-.278.11H7.849a.403.403 0 0 1-.279-.11.453.453 0 0 1-.145-.29l-.356-2.428c-.624-.252-1.143-.557-1.56-.913l-2.315.913c-.238.104-.424.045-.557-.178L.766 13.05a.525.525 0 0 1-.067-.334.433.433 0 0 1 .156-.29l1.96-1.514A6.964 6.964 0 0 1 2.77 10c0-.4.015-.705.045-.913L.855 7.572a.433.433 0 0 1-.156-.29.525.525 0 0 1 .067-.333l1.87-3.208c.134-.223.32-.282.558-.178l2.316.913a7.19 7.19 0 0 1 1.56-.913l.355-2.428a.453.453 0 0 1 .145-.29.403.403 0 0 1 .279-.11h3.742c.103 0 .196.036.278.11.082.075.137.171.167.29l.334 2.428c.58.223 1.106.527 1.582.913l2.294-.913a.493.493 0 0 1 .323-.022c.096.03.174.096.234.2l1.87 3.208c.06.103.082.215.067.334a.433.433 0 0 1-.156.29l-1.937 1.514c.03.208.044.512.044.913 0 .4-.015.705-.044.913z" fill="currentColor"></path></svg>
                </a>
                <a class="export_block export_users hint-bottom-middle-t-info-s-small-mobile  hint-anim" data-hint="Керування витратами" href="{url controller=[SoloDevStyle,CostPrice,ExpensesByMonthsAdmin] return=$smarty.server.REQUEST_URI}">
                    <svg width="20" height="20" viewBox="0 0 21 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><path id="a" d="M.005 0v2.045h20.04V0H.005z"></path></defs><g fill="none" fill-rule="evenodd"><g transform="translate(.595 17.066)"><path d="M19.022 0h-18a1.023 1.023 0 1 0 0 2.045h18a1.023 1.023 0 0 0 0-2.045z" fill="currentColor"></path></g><path d="M2.674 15.566H5.88c.358 0 .648-.29.648-.647V6.055a.648.648 0 0 0-.648-.647H2.674a.648.648 0 0 0-.647.647v8.864c0 .357.29.647.647.647zM9.015 15.566h3.205c.358 0 .647-.29.647-.647V1.624a.648.648 0 0 0-.647-.648H9.015a.648.648 0 0 0-.647.648v13.295c0 .357.29.647.647.647zM15.356 15.566h3.205c.357 0 .647-.29.647-.647v-7.16a.648.648 0 0 0-.647-.647h-3.205a.648.648 0 0 0-.647.648v7.159c0 .357.29.647.647.647z" fill="currentColor"></path></g></svg>    
                </a>
            </div>
        </div>
    </div>
</div>
<div class="boxed fn_toggle_wrap">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <form method="post" class="odm-stats-filters">
                <div class="row">
                    <div class="col-lg-12 col-md-12 d_flex">
                        <div class="date d_flex">
                            <div class="input-group mobile_input-group input-group--date">
                                <span class="input-group-addon-date">{$btr->general_from|escape}</span>
                                <input type="text" class="fn_from_date form-control" name="from_date" value="{$from_date}" autocomplete="off">
                            </div>
                            <div class="input-group mobile_input-group input-group--date">
                                <span class=" input-group-addon-date">{$btr->general_to|escape}</span>
                                <input type="text" class="fn_to_date form-control" name="to_date" value="{$to_date}" autocomplete="off" >
                            </div>
                            <button class="btn btn_blue" type="submit">{$btr->general_apply|escape}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {if $products_without_cost}
    <br>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="alert alert--center alert--icon alert--error">
                <div class="alert__content">
                    <div class="alert__title">
                        <p>Для отримання корректного звіту введіть собівартість для наступних товарів:</p>
                        {foreach $products_without_cost as $product}
                            <p><a class="link" href="{url controller=ProductAdmin id=$product->id return=$smarty.server.REQUEST_URI}">{$product->name}</a></p>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {/if}
    <div class="row stat-bl">
        <div class="col-lg-6 col-md-12">
            <div class="okay_list products_list">
                <div class="okay_list_head">
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_status">Статус</div>
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_quantity">Кіл-ть</div>
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_total">Сума</div>
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_cost">С-Вартість</div>
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_profit">Прибуток</div>
                </div>
                <div class="okay_list_body">
                    <div class="okay_list_body_item">
                        {foreach $stats as $s}
                        <div class="okay_list_row">
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_status">{$s->status}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_quantity">{$s->quantity}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_total">{$s->total} {$currency->sign|escape}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_cost">{$s->cost} {$currency->sign|escape}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_profit">{$s->profit} {$currency->sign|escape}</div>
                        </div>
                        {/foreach}
                        <div class="okay_list_head">
                            <div class="okay_list_heading okay_list_profit_and_expenses_stats_status">Виконаних та відправлених</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_quantity">{$completed_and_sent->quantity}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_total">{$completed_and_sent->total} {$currency->sign|escape}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_cost">{$completed_and_sent->cost} {$currency->sign|escape}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_profit">{$completed_and_sent->profit} {$currency->sign|escape}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12">
            <div class="okay_list products_list">
                <div class="okay_list_head">
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_expenses_name">Витрата</div>
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_expenses_sum">Cума</div>
                </div>
                <div class="okay_list_body">
                    <div class="okay_list_body_item">
                        {foreach $expenses_by_months as $expense_name=>$expense_sum}
                        <div class="okay_list_row">
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_name">{$expense_name}</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_sum">{$expense_sum} {$currency->sign|escape}</div>
                        </div>
                        {/foreach}
                        <div class="okay_list_head">
                            <div class="okay_list_heading okay_list_profit_and_expenses_stats_expenses_name">Всього</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_sum">{$total_expenses} {$currency->sign|escape}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-12">
            <div class="okay_list products_list">
                <div class="okay_list_head">
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_expenses_name">Прибуток</div>
                    <div class="okay_list_heading okay_list_profit_and_expenses_stats_expenses_sum"></div>
                </div>
                <div class="okay_list_body">
                    <div class="okay_list_body_item">
                        <div class="okay_list_row">
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_name">Виконаних та відправлених</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_sum">{$completed_and_sent->profit} {$currency->sign|escape}</div>
                        </div>
                        <div class="okay_list_row">
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_name">Усі витрати</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_sum">{$total_expenses} {$currency->sign|escape}</div>
                        </div>
                        <div class="okay_list_head">
                            <div class="okay_list_heading okay_list_profit_and_expenses_stats_expenses_name">Чистий прибуток</div>
                            <div class="okay_list_boding okay_list_profit_and_expenses_stats_expenses_sum">{$completed_and_sent->profit-$total_expenses} {$currency->sign|escape}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{literal}
<style>
.stat-bl {margin-top: 20px;}
.okay_list_profit_and_expenses_stats_status {width: calc(100% - 400px);text-align: left;}
.okay_list_profit_and_expenses_stats_quantity {width: 40px;font-weight: 800!important;}
.okay_list_profit_and_expenses_stats_total {width: 120px;text-align: right;font-weight: 800!important;}
.okay_list_profit_and_expenses_stats_cost {width: 120px;text-align: right;font-weight: 800!important;}
.okay_list_profit_and_expenses_stats_profit {width: 120px;text-align: right;font-weight: 800!important;}

.okay_list_profit_and_expenses_stats_expenses_name {width: calc(100% - 120px);text-align: left;}
.okay_list_profit_and_expenses_stats_expenses_sum {width: 120px;text-align: right;font-weight: 800!important;}
</style>
{/literal}
{literal}
<script>
    $(function() {
        $('input[name="from_date"]').datepicker({dateFormat: "dd.mm.yy"});
        $('input[name="to_date"]').datepicker({dateFormat: "dd.mm.yy"});
    });
</script>
{/literal}
