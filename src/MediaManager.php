<?php namespace Joanvt\MediaManager;

use Illuminate\Html\HtmlFacade as HTML;
use Config;
use Lang;

class MediaManager
{	
	protected static $MediaModel;
	protected static $modal;
	protected static $upload_route;
	
	
    public static function styles()
    {
		$styles = '';
		$styles .= HTML::style('jmedia/assets/css/style.css');
		return $styles;
    }
	
	public static function lists($model){
		
		self::$upload_route = Config::get('jmedia.upload_route');
		
		$view = '';
		
		$view .= link_to('#', $title = Lang::get('admin.add'), $attributes = array('class'=>'btn btn-primary','type'=>'button','data-toggle'=>'modal','data-target'=>'#uploadmedia'), $secure = null);
		
		
		$view .= '<hr/>';
		
		if($model instanceof \Illuminate\Database\Eloquent\Builder){
			$model = $model->paginate(10);
		}
		
		if($model){
			$view .='<div class="mediaContainer">';
			foreach ($model as $item){
				$view .= '<div class="col-xs-2"><img src="'.url($item->path.'/'.Config::get('jmedia.thumbnail_directory').'/'.$item->name.Config::get('jmedia.width_thumbnail').'x'.Config::get('jmedia.height_thumbnail').'.'.$item->ext).'" class="img-responsive"/></div>';
			}
			$view .='<div class="clearfix"></div>';
			$view .='</div>';
		}
		
		$view .= $model->render();
		
		$view .= '<div class="modal fade" id="uploadmedia" tabindex="-1" role="dialog" aria-labelledby="uploadmediaLabel">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Upload Files</h4>
						  </div>
						  <div class="modal-body">
							<form id="upload" method="post" action="'.self::$upload_route.'" enctype="multipart/form-data">
								<div id="drop">
									Drop Here
									<a>Browse</a>
									<input type="file" name="upl" multiple />
								</div>
								<ul>
									<div class="clearfix"></div>
								</ul>
								'. csrf_field() .'
							</form>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->';
		
		$view .= '<div class="modal fade" id="photoInfo" tabindex="-1" role="dialog" aria-labelledby="uploadmediaLabel">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title photo-name">Image info</h4>
						  </div>
						  <div class="modal-body photo-info">
							 <div class="row">
							 	<div class="col-sm-8">
									<div class="form-group">
										<label for="url-info">Url</label>
										<input data-width="'.Config::get('jmedia.width_thumbnail').'" data-height="'.Config::get('jmedia.height_thumbnail').'" type="text" disabled readonly id="url-info" value="" data-path="'.url(Config::get('jmedia.upload_path').'/').'" class="form-control"	/>
									</div>
								</div>
								<div class="col-sm-4">
									<img src="" class="img-info img-responsive"/>
								</div>
							 </div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						</div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->
		';					
		return $view;
		
	}
	
	public static function scripts(){
		$scripts = '';
		$scripts .= HTML::script('jmedia/assets/js/jquery.knob.js');
		$scripts .= HTML::script('jmedia/assets/js/jquery.ui.widget.js');
		$scripts .= HTML::script('jmedia/assets/js/jquery.iframe-transport.js');
		$scripts .= HTML::script('jmedia/assets/js/jquery.fileupload.js'); 
		$scripts .= HTML::script('jmedia/assets/js/script.js'); 
		return $scripts;
	}
}