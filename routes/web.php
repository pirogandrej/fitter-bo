<?php


Auth::routes();

Route::get('/', 'PostController@posts_posts');
Route::get('/home', 'PostController@posts_posts');
Route::get('/posts', 'PostController@posts_posts')->name('posts_posts');
Route::post('/loaddatapost','PostController@loadDataAjax' )->name('loadmorepost');
Route::get('/posts/top', 'PostController@posts_top')->name('posts_top');
Route::get('/posts/fresh', 'PostController@posts_fresh')->name('posts_fresh');
Route::get('/posts/category', 'PostController@posts_category')->name('posts_category');
Route::get('/posts/{id}', 'PostController@posts_index')->name('posts_post')->where('id', '[0-9]+');
Route::get('/posts/category/{id}', 'PostController@posts_category_description')->name('posts_category_description')->where('id', '[0-9]+');
Route::get('/view/{post_id}', 'PostController@change_view')->name('change_view');
Route::post('/search', 'PostController@search')->name('search');
Route::get('/search_tag/{data}', 'PostController@search_tag')->name('search_tag');
Route::get('/posts/author/{id}', 'PostController@posts_author')->name('posts_author');


/* === FITTER === */

Route::group(['middleware' => ['auth:web', 'fitter:web']], function () {

    Route::get('/fit', 'Fitter\PostController@index')->name('fit_posts');
    Route::get('/fit/posts', 'Fitter\PostController@index')->name('fit_posts');
    Route::get('/fit/post/new', 'Fitter\PostController@new_post')->name('fit_new_post');
    Route::post('/fit/post/insert', 'Fitter\PostController@insert_post')->name('fit_insert_post');
    Route::get('/fit/post/edit/{id}', 'Fitter\PostController@edit_post')->name('fit_edit_post');
    Route::post('/fit/post/update', 'Fitter\PostController@update_post')->name('fit_update_post');
    Route::post('/fit/post/delete', 'Fitter\PostController@delete_post')->name('fit_delete_post');
    Route::get('/fit/profile', 'Fitter\PostController@profile')->name('fit_profile');
    Route::post('/fit/profile/update', 'Fitter\PostController@profile_update')->name('fit_profile_form');

    Route::get('/like/{post_id}', 'Fitter\LikeController@change_like')->name('change_like');
    Route::post('/fit/comments', 'Fitter\CommentController@comment_post')->name('fit_comment_post');

});


/* === ADMIN === */

Route::group(['middleware' => ['auth:web', 'admin:web']], function () {

    Route::get('/admin', 'Admin\AdminUsersController@index')->name('admin_users');
    Route::get('/admin/users', 'Admin\AdminUsersController@index')->name('admin_users');
    Route::get('/admin/profile', 'Admin\AdminUsersController@profile')->name('admin_profile');
    Route::post('/admin/profile/update', 'Admin\AdminUsersController@profile_update')->name('admin_profile_form');
    Route::get('/admin/my_user/new', 'Admin\AdminUsersController@admin_user_new')->name('admin_user_new');
    Route::post('/admin/my_user/insert', 'Admin\AdminUsersController@admin_user_new_form')->name('admin_user_new_form');
    Route::get('/admin/my_user/edit/{id}', 'Admin\AdminUsersController@admin_user_edit')->name('admin_user_edit');
    Route::post('/admin/my_user/update', 'Admin\AdminUsersController@admin_user_update_form')->name('admin_user_update_form');
    Route::post('/admin/my_user/delete', 'Admin\AdminUsersController@admin_user_delete')->name('admin_user_delete');

    Route::get('/admin/posts', 'Admin\AdminPostController@index')->name('admin_all_posts');
    Route::get('/admin/post/edit/{id}', 'Admin\AdminPostController@admin_edit_post')->name('admin_edit_post');
    Route::post('/admin/post/update', 'Admin\AdminPostController@admin_update_post_form')->name('admin_update_post_form');
    Route::post('/admin/post/delete', 'Admin\AdminPostController@admin_delete_post')->name('admin_delete_post');
    Route::post('/admin/post/approved', 'Admin\AdminPostController@admin_approved_post')->name('admin_approved_post');
    Route::post('/admin/post/check', 'Admin\AdminPostController@admin_posts_check_category')->name('admin_posts_check_category');
    Route::post('/admin/post/check_user', 'Admin\AdminPostController@admin_posts_check_user')->name('admin_posts_check_user');

    Route::get('/admin/comments', 'Admin\AdminCommentController@index')->name('admin_all_comments');
    Route::post('/admin/comment/delete', 'Admin\AdminCommentController@admin_delete_comment')->name('admin_delete_comment');
    Route::post('/admin/comment/approved', 'Admin\AdminCommentController@admin_approved_comment')->name('admin_approved_comment');

    Route::get('/admin/categories', 'Admin\AdminCategoryController@index')->name('admin_all_categories');
    Route::get('/admin/category/new', 'Admin\AdminCategoryController@admin_new_category')->name('admin_new_category');
    Route::post('/admin/category/insert', 'Admin\AdminCategoryController@admin_new_category_form')->name('admin_new_category_form');
    Route::get('/admin/category/edit/{id}', 'Admin\AdminCategoryController@admin_edit_category')->name('admin_edit_category');
    Route::post('/admin/category/update', 'Admin\AdminCategoryController@admin_edit_category_form')->name('admin_edit_category_form');
    Route::post('/admin/category/delete', 'Admin\AdminCategoryController@admin_delete_category')->name('admin_delete_category');

});

