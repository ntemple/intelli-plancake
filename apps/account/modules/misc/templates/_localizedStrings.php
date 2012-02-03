<?php
/*************************************************************************************
* ===================================================================================*
* Software by: Danyuki Software Limited                                              *
* This file is part of Plancake.                                                     *
*                                                                                    *
* Copyright 2009-2010-2011-2012 by:     Danyuki Software Limited                          *
* Support, News, Updates at:  http://www.plancake.com                                *
* Licensed under the AGPL version 3 license.                                         *                                                       *
* Danyuki Software Limited is registered in England and Wales (Company No. 07554549) *
**************************************************************************************
* Plancake is distributed in the hope that it will be useful,                        *
* but WITHOUT ANY WARRANTY; without even the implied warranty of                     *
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                      *
* GNU Affero General Public License for more details.                                *
*                                                                                    *
* You should have received a copy of the GNU Affero General Public License           *
* along with this program.  If not, see <http://www.gnu.org/licenses/>.              *
*                                                                                    *
**************************************************************************************/
?>
<script type="text/javascript">
    var pc_lang_dow_mon = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_MON') ?>';
    var pc_lang_dow_tue = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_TUE') ?>';
    var pc_lang_dow_wed = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_WED') ?>';
    var pc_lang_dow_thu = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_THU') ?>';
    var pc_lang_dow_fri = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_FRI') ?>';
    var pc_lang_dow_sat = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_SAT') ?>';
    var pc_lang_dow_sun = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_DOW_SUN') ?>';

    var pc_lang_month_jan = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_JAN') ?>';
    var pc_lang_month_feb = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_FEB') ?>';
    var pc_lang_month_mar = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_MAR') ?>';
    var pc_lang_month_apr = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_APR') ?>';
    var pc_lang_month_may = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_MAY') ?>';
    var pc_lang_month_jun = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_JUN') ?>';
    var pc_lang_month_jul = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_JUL') ?>';
    var pc_lang_month_aug = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_AUG') ?>';
    var pc_lang_month_sep = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_SEP') ?>';
    var pc_lang_month_oct = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_OCT') ?>';
    var pc_lang_month_nov = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_NOV') ?>';
    var pc_lang_month_dec = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MONTH_DEC') ?>';

    var pc_lang_next = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MISC_NEXT') ?>';
    var pc_lang_prev = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_MISC_PREV') ?>';

    var pc_lang_feedback_box_thank_you = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_FEEDBACK_THANK_YOU') ?>';

    var pc_lang_inbox_list = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_LISTS_INBOX')) ?>';
    var pc_lang_todo_list = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_LISTS_TODO')) ?>';

    var pc_lang_confirm_msg = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_MISC_CONFIRM_MSG')) ?>';

    var pc_lang_success_tag_deleted = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TAG_DELETED')) ?>';
    var pc_lang_success_tags_reordered = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TAGS_REORDERED')) ?>';
    var pc_lang_success_tag_added = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TAG_ADDED')) ?>';
    var pc_lang_success_tag_updated = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TAG_UPDATED')) ?>';

    var pc_lang_fetching_scheduled_tasks = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_MAIN_CONTENT_FETCHING_SCHEDULED_TASKS')) ?>';
    var pc_lang_error_occurred_retry = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_ERROR_OCCURRED_PLEASE_RETRY')) ?>';

    var pc_lang_success_note_deleted = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_NOTE_DELETED')) ?>';
    var pc_lang_enter_note_title = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_NOTES_ENTER_NOTE_TITLE')) ?>';
    var pc_lang_note = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_NOTES_NOTE')) ?>';
    var pc_lang_success_note_saved = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_NOTE_SAVED')) ?>';
    var pc_lang_error_note_title_too_long = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_NOTE_TITLE_TOO_LONG')) ?>';
    var pc_lang_error_note_content_too_long = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_NOTE_CONTENT_TOO_LONG')) ?>';

    var pc_lang_confirm_delete_list = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_LISTS_CONFIRM_DELETE')) ?>';
    var pc_lang_success_list_deleted = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_LIST_DELETED')) ?>';
    var pc_lang_error_no_lists_to_reorder = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_NO_LISTS_TO_REORDER')) ?>';
    var pc_lang_success_lists_reordered = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_LIST_REORDERED')) ?>';
    var pc_lang_success_list_added = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_LIST_ADDED')) ?>';
    var pc_lang_success_list_updated = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_LIST_UPDATED')) ?>';

    var pc_lang_redirecting_to_new_list = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_LISTS_REDIRECTING_TO_NEW_LIST')) ?>';


    var pc_lang_success_task_deleted = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASK_DELETED')) ?>';
    var pc_lang_success_tasks_reordered = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASKS_REORDERED')) ?>';
    var pc_lang_success_task_added = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASK_ADDED')) ?>';
    var pc_lang_success_task_updated = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASK_UPDATED')) ?>';

    var pc_lang_error_no_task_description = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_NO_TASK_DESCRIPTION')) ?>';
    var pc_lang_error_no_tasks_to_reorder = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_NO_TASKS_TO_REORDER')) ?>';
    var pc_lang_error_only_one_task_to_reorder = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_ONLY_ONE_TASK_TO_REORDER')) ?>';
    var pc_lang_error_cant_reorder_while_tag_filter = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_CANT_REORDER_WHILE_FILTER_BY_TAG')) ?>';
    var pc_lang_error_cant_add_below_task = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_ERROR_CANT_ADD_BELOW_TASK')) ?>';

    var pc_lang_cant_reorder_these_tasks = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_MAIN_CONTENT_CANT_REORDER_THESE_TASKS')) ?>';
    var pc_lang_task_marked_as_done = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASK_MARKED_AS_DONE')) ?>';
    var pc_lang_task_marked_as_to_do = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASK_MARKED_AS_TO_DO')) ?>';
    var pc_lang_task_starred_unstarred = '<?php echo trim(PcUtils::makeLangStringAvailableToJs('ACCOUNT_SUCCESS_TASK_STARRED_UNSTARRED')) ?>';

    var pc_lang_new_tag = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_TAGS_NEW_TAG') ?>';
    var pc_lang_edit_tag = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_TAGS_EDIT_TAG') ?>';
    var pc_lang_new_list = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_NEW_LIST') ?>';
    var pc_lang_edit_list = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_EDIT_LIST') ?>';
    var pc_lang_new_task = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_NEW_TASK') ?>';
    var pc_lang_edit_task = '<?php echo PcUtils::makeLangStringAvailableToJs('ACCOUNT_EDIT_TASK') ?>';
</script>
