<?php

Route::get('email-to-friend/{job_slug}', 'ContactController@emailToFriend')->name('email.to.friend');
Route::post('email-to-friend/{job_slug}', 'ContactController@emailToFriendPost')->name('email.to.friend');
Route::get('email-to-friend-thanks', 'ContactController@emailToFriendThanks')->name('email.to.friend.thanks');
//Route::get('report-abuse/{job_slug}', 'ContactController@reportAbuse')->name('report.abuse');
Route::post('report-abuse', 'ContactController@reportAbusePost')->name('report.abuse');
Route::get('report-abuse-thanks', 'ContactController@reportAbuseThanks')->name('report.abuse.thanks');

