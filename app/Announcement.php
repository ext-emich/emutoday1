<?php

namespace emutoday;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;

class Announcement extends Model
{
  use PresentableTrait;
  protected $presenter = 'emutoday\Presenters\AnnouncementPresenter';
  protected $fillable = ['user_id', 'title', 'announcement', 'start_date', 'end_date','link_txt', 'link', 'is_promoted', 'is_approved', 'link_txt','link','mail_link_txt', 'mail_link'];
  protected $dates = ['end_date', 'start_date', 'submission_date', 'approved_date'];



    public function user()
    {
        return $this->belongsTo('emutoday\User');
    }

    // public function author_name()
    // {
    // 	return $this->author->last_name;
    // }
}
