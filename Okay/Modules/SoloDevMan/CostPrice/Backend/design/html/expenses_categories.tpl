{$meta_title='Категорії витрат' scope=global}
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="wrap_heading">
            <div class="box_heading heading_page">Категорії витрат - {$categories_count}</div>
            <div class="box_btn_heading">
              <a class="btn btn_small btn-info" href="{url controller=[SoloDevMan,CostPrice,ExpensesCategoryAdmin] return=$smarty.server.REQUEST_URI}">
                {include file='svg_icon.tpl' svgId='plus'}
                <span>Додати категорію</span>
              </a>
            </div>
        </div>
    </div>
</div>
{*Блок фильтров*}
<div class="boxed fn_toggle_wrap">
    <div class="row">
        <div class="col-lg-12 col-md-12 ">
            <div class="fn_toggle_wrap">
                <div class="heading_box visible_md">
                    {$btr->general_filter|escape}
                    <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                        <a class="btn-minimize" href="javascript:;" ><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                    </div>
                </div>
                <div class="boxed_sorting toggle_body_wrap off fn_card">
                <div class="row">
                    <div class="col-md-4 col-lg-4 col-sm-12">
                        <div>
                            <select class="selectpicker form-control" onchange="location = this.value;">
                                <option value="{url keyword=null page=null filter=null}" {if !$filter}{/if}>Усі</option>
                                <option value="{url keyword=null page=null filter='visible'}" {if $filter=='visible'}selected{/if}>Ввімкнені</option>
                                <option value="{url keyword=null page=null filter='hidden'}" {if $filter=='hidden'}selected{/if}>Вимкнені</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    {*Главная форма страницы*}
    {if $categories}
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form class="fn_form_list" method="post">
                    <div id="main_list" class=" okay_list products_list fn_sort_list">
                        <input type="hidden" name="session_id" value="{$smarty.session.id}" />
                        {*Шапка таблицы*}
                        <div class="okay_list_head">
                            <div class="okay_list_heading okay_list_drag"></div>
                            <div class="okay_list_heading okay_list_check">
                                <input class="hidden_check fn_check_all" type="checkbox" id="check_all_1" name="" value=""/>
                                <label class="okay_ckeckbox" for="check_all_1"></label>
                            </div>
                            <div class="okay_list_heading okay_list_expenses_category_name">{$btr->general_name|escape}</div>
                            <div class="okay_list_heading okay_list_status">{$btr->general_enable|escape}</div>
                            <div class="okay_list_heading okay_list_close"></div>
                        </div>
    
                        {*Параметры элемента*}
                        <div class="banners_wrap okay_list_body features_wrap sortable">
                            {foreach $categories as $category}
                            <div class="fn_row okay_list_body_item fn_sort_item">
                                <div class="okay_list_row">
                                    <input type="hidden" name="positions[{$category->id}]" value="{$category->position|escape}">
    
                                    <div class="okay_list_boding okay_list_drag move_zone">
                                        {include file='svg_icon.tpl' svgId='drag_vertical'}
                                    </div>
    
                                    <div class="okay_list_boding okay_list_check">
                                        <input class="hidden_check" type="checkbox" id="id_{$category->id}" name="check[]" value="{$category->id}"/>
                                        <label class="okay_ckeckbox" for="id_{$category->id}"></label>
                                    </div>
    
                                    <div class="okay_list_boding okay_list_expenses_category_name">
                                        <a class="link" href="{url controller=[SoloDevMan,CostPrice,ExpensesCategoryAdmin] id=$category->id return=$smarty.server.REQUEST_URI}">
                                            {$category->name|escape}
                                        </a>
                                    </div>
    
                                    <div class="okay_list_boding okay_list_status">
                                        {*visible*}
                                        <label class="switch switch-default">
                                            <input class="switch-input fn_ajax_action {if $category->visible}fn_active_class{/if}" data-controller="solo_dev_man__expenses_category" data-action="visible" data-id="{$category->id}" name="visible" value="1" type="checkbox"  {if $category->visible}checked=""{/if}/>
                                            <span class="switch-label"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </div>
                                    <div class="okay_list_boding okay_list_close">
                                        {*delete*}
                                        <button data-hint="{$btr->banners_images_delete|escape}" type="button" class="btn_close fn_remove hint-bottom-right-t-info-s-small-mobile  hint-anim" data-toggle="modal" data-target="#fn_action_modal" onclick="success_action($(this));">
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
                                <div class="okay_list_heading okay_list_drag"></div>
                                <div class="okay_list_heading okay_list_check">
                                    <input class="hidden_check fn_check_all" type="checkbox" id="check_all_2" name="" value=""/>
                                    <label class="okay_ckeckbox" for="check_all_2"></label>
                                </div>
                                <div class="okay_list_option">
                                    <select name="action" class="selectpicker form-control">
                                        <option value="enable">{$btr->general_do_enable|escape}</option>
                                        <option value="disable">{$btr->general_do_disable|escape}</option>
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
    .okay_list .okay_list_expenses_category_name {width: calc(100% - 230px);}
</style>
{/literal}
