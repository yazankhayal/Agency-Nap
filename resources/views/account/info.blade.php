<form class="ajaxForm profile ho-form" enctype="multipart/form-data"
      data-name="profile"
      action="{{route('profile')}}" method="post" xmlns="http://www.w3.org/1999/html">
    {{csrf_field()}}
    <input class="form-control" type="hidden" name="id" id="id"/>
    <div class="ho-form-inner">
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('FullName')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('FullName')}}" id="name" name="name"
                       value="{{$current_user != null ? $current_user->name : ""}}"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Email')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('Email')}}" id="email" name="email"
                       value="{{$current_user != null ? $current_user->email : ""}}"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Avatar')}} <span class="required">*</span></label>
                <input type="file" placeholder="{{lang_name('Avatar')}}" id="avatar" name="avatar">
                @if($current_user->avatar != null)
                    <img src="{{$get_url_photo.$current_user->avatar}}" class="img-thumbnail" style="width: 100px;height: 80px;;">
                @endif
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Password')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('Password')}}" id="password" name="password"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Password2')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('Password2')}}" id="password_confirmation" name="password_confirmation"/>
            </div>
        </div>
        <div class="single-input">
            <button class="ho-button ho-button-dark" type="submit"><span>{{lang_name('Submit')}}</span></button>
        </div>
    </div>
</form>