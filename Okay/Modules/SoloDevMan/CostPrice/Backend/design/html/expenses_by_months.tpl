{$meta_title='Витрати по місяцям' scope=global}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">Витрати по місяцям - {$expenses_count}</div>
            <div class="box_btn_heading">
              <a class="btn btn_small btn-info" href="{url controller=[SoloDevMan,CostPrice,ExpensesByMonthAdmin] return=$smarty.server.REQUEST_URI}">
                {include file='svg_icon.tpl' svgId='plus'}
                <span>Додати витрати</span>
              </a>
            </div>
        </div>
    </div>
</div>
<div class="boxed fn_toggle_wrap">
    {*Главная форма страницы*}
    {if $expenses}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form class="fn_form_list" method="post">
                    <div id="main_list" class=" okay_list products_list fn_sort_list">
                        <input type="hidden" name="session_id" value="{$smarty.session.id}" />
                        {*Шапка таблицы*}
                        <div class="okay_list_head">
                            <div class="okay_list_heading okay_list_check">
                                <input class="hidden_check fn_check_all" type="checkbox" id="check_all_1" name="" value=""/>
                                <label class="okay_ckeckbox" for="check_all_1"></label>
                            </div>
                            <div class="okay_list_heading okay_list_expenses_month_name">Дата</div>
                            <div class="okay_list_heading okay_list_close"></div>
                        </div>
    
                        {*Параметры элемента*}
                        <div class="banners_wrap okay_list_body features_wrap sortable">
                            {foreach $expenses as $expense}
                            <div class="fn_row okay_list_body_item fn_sort_item">
                                <div class="okay_list_row">
                                    <div class="okay_list_boding okay_list_check">
                                        <input class="hidden_check" type="checkbox" id="id_{$expense->id}" name="check[]" value="{$expense->id}"/>
                                        <label class="okay_ckeckbox" for="id_{$expense->id}"></label>
                                    </div>
    
                                    <div class="okay_list_boding okay_list_expenses_month_name">
                                        <a class="link" href="{url controller=[SoloDevMan,CostPrice,ExpensesByMonthAdmin] id=$expense->id return=$smarty.server.REQUEST_URI}">
                                            {$expense->date|escape}
                                        </a>
                                    </div>
                                    <div class="okay_list_boding okay_list_close">
                                        {*delete*}
                                        <button data-hint="Видалити" type="button" class="btn_close fn_remove hint-bottom-right-t-info-s-small-mobile  hint-anim" data-toggle="modal" data-target="#fn_action_modal" onclick="success_action($(this));">
                                            {include file='svg_icon.tpl' svgId='trash'}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            {/foreach}
                        </div>
    
                        {*Блок массовых действий*}
                        <div class="okay_list_footer fn_action_block">
                            <div class="okay_list_foot_left">
                                <div class="okay_list_heading okay_list_check">
                                    <input class="hidden_check fn_check_all" type="checkbox" id="check_all_2" name="" value=""/>
                                    <label class="okay_ckeckbox" for="check_all_2"></label>
                                </div>
                                <div class="okay_list_option">
                                    <select name="action" class="selectpicker form-control">
                                        <option value="delete">{$btr->general_delete|escape}</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn_small btn_blue">
                                {include file='svg_icon.tpl' svgId='checked'}
                                <span>{$btr->general_apply|escape}</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm 12 txt_center">
                {include file='pagination.tpl'}
            </div>
        </div>
    {else}
        <div class="heading_box mt-1">
            <div class="text_grey">Список витрат відсутній</div>
        </div>
    {/if}
</div>
{literal}
<style>
    .okay_list .okay_list_expenses_month_name {width: calc(100% - 90px);}
</style>
{/literal}
