<?php namespace Joanvt\MediaManager;

use Collective\Html\HtmlFacade as HTML;
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
		
		self::$upload_route = url(Config::get('jmedia.upload_route'));
		
		
		// Translations
		$delete = (Lang::has('jmedia.delete_perma')) ? Lang::get('jmedia.delete_perma') : 'Delete permanently';  
		$info = (Lang::has('jmedia.info_image')) ? Lang::get('jmedia.info_image') : 'Upload Image';  
		$upload_image = (Lang::has('jmedia.upload_image')) ? Lang::get('jmedia.upload_image') : 'Upload Image';  
		$close = (Lang::has('jmedia.close')) ? Lang::get('jmedia.delete_closeperma') : 'Close';  
		
		
		$view = '';
		
		$view .= link_to('#', $title = Lang::get('admin.add'), $attributes = array('class'=>'btn btn-primary','type'=>'button','data-toggle'=>'modal','data-target'=>'#uploadmedia'), $secure = null);
		
		
		$view .= '<hr/>';
		
		if($model instanceof \Illuminate\Database\Eloquent\Builder){
			$model = $model->paginate(10);
		}
		
		if($model){
			$view .='<div class="mediaContainer"><div class="row">';
			foreach ($model as $item){
				$view .= '<div class="col-xs-6 col-sm-4 col-md-2 jmedia-item">
					<div class="hover ehover13"><img data-ref="'.$item->id.'" src="'.url($item->path.'/'.Config::get('jmedia.thumbnail_directory').'/'.$item->name.Config::get('jmedia.width_thumbnail').'x'.Config::get('jmedia.height_thumbnail').'.'.$item->ext).'" class="img-responsive" path-dir="'.url($item->path).'"/>
				<div class="overlay">
						<h2><span class="glyphicon glyphicon-search" aria-hidden="true"></span></h2>
					</button>
					</div>	
				</div>
				</div>';
			}
			$view .='<div class="clearfix"></div>';
			$view .='</div></div>';
		}
		
		$view .= $model->render();
		
		$view .= '<div class="modal fade" id="uploadmedia" tabindex="-1" role="dialog" aria-labelledby="uploadmediaLabel">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">'.$upload_image.'</h4>
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
							<button type="button" class="btn btn-default" data-dismiss="modal">'.$close.'</button>
						  </div>
						</div><!-- /.modal-content -->
					  </div><!-- /.modal-dialog -->
					</div><!-- /.modal -->';
		
		$view .= '<div class="modal fade" id="photoInfo" tabindex="-1" role="dialog" aria-labelledby="uploadmediaLabel">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title photo-name">'.$info.'</h4>
						  </div>
						  <div class="modal-body photo-info">
							 <div class="row">
							 	<div class="col-sm-8">
									<div class="form-group">
										<label for="url-info">Url</label>
										<input data-width="'.Config::get('jmedia.width_thumbnail').'" data-height="'.Config::get('jmedia.height_thumbnail').'" type="text" disabled readonly id="url-info" value="" data-path="'.url(Config::get('jmedia.upload_path').'/').'" thumb-data="'.Config::get('jmedia.thumbnail_directory').'" class="form-control"	/>
									</div>
									<div class="form-group">
										<a href="javascript:" id="delbtn" class="btn btn-danger" role="button" data-del="">
											'.$delete.'
										</a>
									</div>
								</div>
								<div class="col-sm-4">
									<img src="" class="img-info img-responsive"/>
								</div>
							 </div>
						  </div>
						  <div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">'.$close.'</button>
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
		$scripts .= '<script type="text/javascript">$("#delbtn").click(function(e){
						var data = {
							ref : $("#delbtn").attr("data-del"),
							_token : "'.csrf_token().'"
						};
						
						var conf =  confirm("Sure you want to delete?");
						if(conf){
							$.ajax({
							  url: "'.self::$upload_route.'/delete",
							  data: data,
							  method: "POST",
							  beforeSend: function( xhr ) {
								xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
							  }
							})
							  .done(function( response ) {
								$("#photoInfo").modal("hide");
								$("img[data-ref="+data.ref+"]").parent().remove();
							  });
						}
					});</script>';
		return $scripts;
	}
}
