{if $expense->id}
{$meta_title = $expense->date scope=global}
{else}
{$meta_title = 'Додати витрати' scope=global}
{/if}

{*Название страницы*}
<div class="row">
<div class="col-lg-12 col-md-12">
    <div class="wrap_heading">
        <div class="box_heading heading_page">
            {if !$expense->id}
                Витрати за місяць
            {else}
                Витрати за {$expense->date|escape}
            {/if}
        </div>
    </div>
</div>
</div>

{*Вывод успешных сообщений*}
{if $message_success}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="alert alert--center alert--icon alert--success">
            <div class="alert__content">
                <div class="alert__title">
                    {if $message_success == 'added'}
                        Витрати додані
                    {elseif $message_success == 'updated'}
                        Витрати оновлені
                    {/if}
                </div>
            </div>
            {if $smarty.get.return}
            <a class="alert__button" href="{$smarty.get.return}">
                {include file='svg_icon.tpl' svgId='return'}
                <span>{$btr->general_back|escape}</span>
            </a>
            {/if}
        </div>
    </div>
</div>
{/if}

{*Вывод ошибок*}
{if $message_error}
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="alert alert--center alert--icon alert--error">
            <div class="alert__content">
                <div class="alert__title">
                    {if $message_error=='date_exists'}
                        Для цього місяця вже вказані витрати. Спочатку видаліть попередні.
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>
{/if}

{*Главная форма страницы*}
<form method="post" enctype="multipart/form-data" class="fn_fast_button">
<input type=hidden name="session_id" value="{$smarty.session.id}">
<input type="hidden" name="lang_id" value="{$lang_id}" />
<div class="row">
    <div class="col-xs-12">
        <div class="boxed">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="heading_label">
                        Місяць
                    </div>
                    <div class="form-group">
                        {if $expense->id}
                            <input class="form-control mb-h" type="text" disabled value="{$expense->date|escape}"/>
                        {else}
                            <select name="date" class="selectpicker form-control">
                                {foreach $months as $month}
                                    <option value="{$month->month_year}">{$month->month_year}</option>
                                {/foreach}
                            </select>
                        {/if}
                        <input name="id" type="hidden" value="{$expense->id|escape}"/>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="boxed fn_toggle_wrap">
                        <div class="heading_box">
                            Витрати
                            <div class="toggle_arrow_wrap fn_toggle_card text-primary">
                                <a class="btn-minimize" href="javascript:;"><i class="fa fn_icon_arrow fa-angle-down"></i></a>
                            </div>
                        </div>
                        <div class="toggle_body_wrap on fn_card">
                            <div class="row d_flex">
                                {if $expense->id}
                                    {foreach $expense->expenses as $category => $value}
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="heading_label">
                                            {$category}
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control mb-h" disabled type="text" value="{$value}"/>
                                        </div>
                                    </div>
                                    {/foreach}
                                {else}
                                    {foreach $categories as $category}
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="heading_label">
                                            {$category->name}
                                        </div>
                                        <div class="form-group">
                                            <input class="form-control mb-h" name="expenses[{$category->name}]" type="text" value=""/>
                                        </div>
                                    </div>
                                    {/foreach}
                                {/if}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{if !$expense->id}
<div class="row">
    <div class="col-lg-12 col-md-12 ">
        <button type="submit" class="btn btn_small btn_blue float-md-right">
            {include file='svg_icon.tpl' svgId='checked'}
            <span>{$btr->general_apply|escape}</span>
        </button>
    </div>
</div>
{/if}
</form>
