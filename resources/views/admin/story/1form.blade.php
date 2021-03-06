<!-- Story Form -->
@extends('admin.layouts.adminlte')
@section('title', $story->exists ? 'Editing '.$story->title : 'Create New Story')
    @section('style-plugin')
        @parent
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="/themes/admin-lte/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" type="text/css" href="/themes/plugins/flatpickr.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="/themes/admin-lte/plugins/select2/select2.min.css">

<link rel="stylesheet" href="/themes/plugins/eonasdan-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">

    @endsection
        @section('scripts-vendor')
            <!-- Vendor Scripts that need to be loaded in the header before other plugin or app scripts -->
            @parent
        @endsection
        @section('scripts-plugin')
            <!-- Scripts  for code libraries and plugins that need to be loaded in the header -->
            <script src="/themes/plugins/ckeditor/ckeditor.js"></script>
            @parent
        @endsection
        @section('scripts-app')
            <!-- App related Scripts  that need to be loaded in the header -->
            @parent

        @endsection


        @section('content')
        <div  class="row">
            <div class="col-md-7">
                <div id="vue-story-form-wrapper">


                <div class="box box-primary">
                        <div class="box-header with-border">
                            <div id="vue-box-tools">
                                <box-tools v-ref:boxtools rte="{{$stype}}" viewtype="form"
                                :current-user="{{$currentUser}}"
                                :record-id="{{$story->exists ? $story->id: null}}"
                                ></box-tools>
                            </div>
                        </div> 	<!-- /.box-header -->
                    <div class="box-body">
                        <story-form
                            :cuser="{{$currentUser}}"
                            recordexists="{{$story->exists ? true: false}}"

                            stypes="{{$stypes}}"

                            editid="{{$story->exists ? $story->id : null }}">
                            <input slot="csrf" type="hidden" name="_token" value="{{ csrf_token() }}">
                        </story-form>
                  </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.id="vue-story-form-wrapper" -->
        </div><!-- /.col-md-6 -->
        <div class="col-md-5">
                @can('admin', $currentUser)
                @if($story->exists)
                        @if($story->story_type == 'news')
                                <div class="box box-warning">
                                    <div class="box-header with-border">
                                        <form action="promoteStory" method="POST">
                                            {{ csrf_field() }}
                                            {!! Form::select('new_story_type', $stypelist, 'story', ['class' => 'form-control']) !!}
                                            <button class="btn btn-primary" href="#">Promote Story</button>
                                        </form>
                                    </div>
                                </div>
                        @else
                            @if ($story->storyImages()->count() > 0 && $story->storyImages()->count() < 3 )
                                
                            @if ($requiredImages->count() > 0)
                                @foreach($requiredImages as $requiredImage)
                                    {{$requiredImage->name}}
                                @endforeach

                            @endif
                            @if ($otherImages->count() > 0)
                                @foreach($otherImages as $otherImage)
                                    {{$otherImage->name}}
                                @endforeach
                            @endif

                            @if ($story->storyImages()->count() > 0)
                                    @foreach($story->storyImages as $storyImage)
                                        @if($storyImage->image_type == 'small')
                                            @include('admin.storyimages.subviews.smallimage',['storyImage' => $storyImage, 'story_id' => $story->id ])
                                        @elseif($storyImage->image_type == 'story')
                                            @include('admin.storyimages.subviews.storyimage',['storyImage' => $storyImage, 'story_id' => $story->id ])
                                        @elseif($storyImage->image_type == 'front')
                                            @include('admin.storyimages.subviews.frontimage',['storyImage' => $storyImage, 'story_id' => $story->id ])
                                        @else
                                            @include('admin.storyimages.subviews.otherimage',['storyImage' => $storyImage, 'story_id' => $story->id ])
                                        @endif
                                    @endforeach
                            @endif
                            @if ($leftOverImages->count() > 0)
                                    @foreach($leftOverImages as $leftOverImage)
                                            @include('admin.story.subviews.addstoryimage',['otherImage' => $leftOverImage, 'story_id' => $story->id ])
                                    @endforeach

                                @endif
                        @endif

                    @endif
                @endcan



        </div><!-- /.col-md-4 -->

</div><!-- /.row -->
@endsection
@section('footer-plugin')
    @parent

<!-- Select2 -->
<script src="/themes/admin-lte/plugins/select2/select2.full.min.js"></script>
<!-- InputMask -->
<script src="/themes/admin-lte/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/themes/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/themes/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

<script src="/themes/plugins/eonasdan-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>


<script src="/themes/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="/themes/admin-lte/plugins/iCheck/icheck.min.js"></script>
<!-- FastClick -->
<script src="/themes/admin-lte/plugins/fastclick/fastclick.js"></script>

    @endsection
    @section('scriptsfooter')
        @parent

    @endsection
    @section('footer-script')
        @parent
        <script src="/js/vue-story-form-wrapper.js"></script>

<script>
$(function () {
    var itemrte = JSvars.stype;

    $(".select2").select2();


        $('input[type="radio"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        })

        if (JSvars.is_featured == 1) {
            $('#is-featured-yes').iCheck('check');

        } else {
            $('#is-featured-no').iCheck('check');
            $('#is-featured-yes').iCheck('disable');
        }


    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass: 'iradio_minimal-blue'
    });


        //Start Date picker
        $('#start-date').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        //End Date picker
        // $('#end-date').datetimepicker({
        //     format: 'YYYY-MM-DD HH:mm:ss',
        //     useCurrent: false //Important! See Issue #1075
        // });
        // $("#start-date").on("dp.change", function (e) {
        //             $('#end-date').data("DateTimePicker").minDate(e.date);
        //     });
        //     $("#end-date").on("dp.change", function (e) {
        //             $('#start-date').data("DateTimePicker").maxDate(e.date);
        //     });

        // document.getElementById("externalButton").onclick = function () {
        //
        // var vuedata = document.getElementById("vue-box-tools");
        // // vm.$refs.boxtools.setDirtyValue = 99;
        // console.log('vuedata===='+ vuedata.$data);
    // }
        // $('#vue-box-tools').$refs.boxtools.setDirtyValue = 99;
  });
// $('input[name=title]').on('blur', function () {
//         var slugElement = $('input[name=slug]');
//
//         if (slugElement.val()) {
//                 return;
//         }
//
//         slugElement.val(this.value.toLowerCase().replace(/[^a-z0-9-]+/g, '-').replace(/^-+|-+$/g, ''));
// });



</script>
@endsection
