<?php
/**
 * Page titles
 */
function roots_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return __('Latest Posts', 'stances');
    }
  } elseif (is_archive()) {
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    if ($term) {
      return apply_filters('single_term_title', $term->name);
    } elseif (is_post_type_archive()) {

      if(isset(get_queried_object()->term_id) && get_queried_object()->term_id) {

        $term_slug = get_queried_object()->slug;

        return '<p><img src="' . get_template_directory_uri() . '/assets/img/title-'. $term_slug  .'.png"></p>';
        
      }
      else if(get_queried_object()->labels) {

        return apply_filters('the_title', get_queried_object()->labels->name);

      }

    } elseif (is_day()) {
      return sprintf(__('Daily Archives: %s', 'stances'), get_the_date());
    } elseif (is_month()) {
      return sprintf(__('Monthly Archives: %s', 'stances'), get_the_date('F Y'));
    } elseif (is_year()) {
      return sprintf(__('Yearly Archives: %s', 'stances'), get_the_date('Y'));
    } elseif (is_author()) {
      $author = get_queried_object();
      return sprintf(__('Author Archives: %s', 'stances'), $author->display_name);
    } else {
      return single_cat_title('', false);
    }
  } elseif (is_search()) {
    return sprintf(__('Search Results for %s', 'stances'), get_search_query());
  } elseif (is_404()) {
    return __('Not Found', 'stances');
  } else {
    return '';//get_the_title();
  }
}