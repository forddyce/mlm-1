@extends('front.app')

@section('title')
@lang('pageSettings.title') - {{ config('app.name') }}
@stop

@section('content')
@include('front.include.header')
<div id="base">
  <div class="offcanvas"></div>
  <div id="content">
    <section>
      <div class="section-body">
        <div class="row">
          <div class="col-lg-8">
            <div class="card">
              <div class="card-head">
                <header class="text-primary">@lang('pageSettings.title')</header>
              </div>

              <div class="card-body">
                <form role="form" class="form action-form" onsubmit="return false;" data-url="{{ route('account.update') }}" http-type="post">
                  <div class="form-group">
                    <label class="control-label" for="fullname">@lang('pageSettings.name')</label>
                    <input type="text" value="{{ $user->first_name }}" name="first_name" id="fullname" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="gender">@lang('pageSettings.gender')</label>
                    <select class="form-control" name="gender" id="gender">
                      <option value="male" @if ($member->gender == 'male') selected="" @endif>@lang('pageSettings.male')</option>
                      <option value="female" @if ($member->gender == 'female') selected="" @endif>@lang('pageSettings.female')</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="dob">@lang('pageSettings.dob')</label>
                    <input type="text" value="{{ $member->date_of_birth }}" name="date_of_birth" id="dob" required="" class="input-date form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="fullname">@lang('pageSettings.nationality')</label>
                    <select class="form-control" name="nationality">
                      <?php $countries = config('misc.countries'); ?>
                      @foreach ($countries as $country)
                        <option value="{{ $country }}" @if ($member->nationality == $country) selected="" @endif>{{ $country }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="phone">@lang('pageSettings.phone')</label>
                    <input type="text" value="{{ $member->phone }}" name="phone" id="phone" required="" class="form-control">
                  </div>

                  <div class="form-group">
                    <div class="alert alert-info">@lang('pageSettings.helpPassword')</div>
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="password">@lang('pageSettings.newPassword')</label>
                    <input type="password" minlength="5" name="password" id="password" class="form-control">
                  </div>

                  <div class="form-group">
                    <label class="control-label" for="repassword">@lang('pageSettings.newRePassword')</label>
                    <input type="password" minlength="5" id="repassword" data-parsley-equalto="#password" class="form-control">
                  </div>

                  <div class="form-actions">
                    <button class="btn btn-primary btn-raised" type="submit">
                      <span class="btn-preloader">
                        <i class="md md-refresh icon-spin"></i>
                      </span>
                      <span>@lang('pageSettings.submit')</span>
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  @include('front.include.sidebar')
</div>
@stop
