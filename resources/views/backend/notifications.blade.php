                    @foreach($notifications as $notification)

                    <a class="dropdown-item" href="#">
                      <div class="d-flex align-items-center">
                         <img src="{{asset($notification->user_img)}}" alt="" class="rounded-circle" width="52" height="52">
                         
                         <div class="ms-3 flex-grow-1">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0 dropdown-msg-user">{{$notification->user_name}} </h6>
                                <div>
                                    <button class="btn btn-primary messages close-notification" data-type="single_user" data-view_type="" data-id="{{$notification->id}}">x</button>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small style="white-space: break-spaces;" class="mb-0 dropdown-msg-text text-secondary d-flex align-items-center">{{$notification->message}}</small>
                                <span class="msg-time float-end text-secondary">{{ Helper::notification_timing($notification->created_at)}}</span>
                            </div>
                           
                           
                         </div>
                      </div>
                    </a>
                    @endforeach