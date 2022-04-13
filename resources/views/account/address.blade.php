<form class="ajaxForm post_data ho-form" enctype="multipart/form-data"
      data-name="post_data"
      action="{{route('address.post_data')}}" method="post" xmlns="http://www.w3.org/1999/html">
    {{csrf_field()}}
    <input class="form-control" type="hidden" name="id" id="id"/>

    <div class="ho-form-inner">
        <div class="single-input">
            <div class="checkout-form-list">
                <label>{{lang_name('f_Name')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('f_Name')}}" id="f_name" name="f_name"
                       value="{{$address != null ? $address->f_name : ""}}"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('l_Name')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('l_Name')}}" id="l_name" name="l_name"
                       value="{{$address != null ? $address->l_name : ""}}"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Address')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('Address')}}" id="address" name="address"
                       value="{{$address != null ? $address->address : ""}}"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Email')}} <span class="required">*</span></label>
                <input type="email" placeholder="{{lang_name('Email')}}" value="{{$user != null ? $user->email : ""}}" disabled/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Phone')}} <span class="required">*</span></label>
                <input type="text" placeholder="{{lang_name('Phone')}}" id="phone" name="phone"
                       value="{{$address != null ? $address->phone : ""}}"/>
            </div>
        </div>
        <div class="single-input">
            <div class="checkout-form-list mb-30">
                <label>{{lang_name('Note')}} </label>
                <textarea rows="5" placeholder="{{lang_name('Note')}}" id="note"
                          name="note">{{$address != null ? $address->note : ""}}</textarea>
            </div>
        </div>
        <div class="single-input">
            <button class="ho-button ho-button-dark" type="submit"><span>{{lang_name('Submit')}}</span></button>
        </div>
    </div>
</form>