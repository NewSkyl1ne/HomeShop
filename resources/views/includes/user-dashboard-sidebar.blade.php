        <div class="col-lg-4">
          <div class="user-profile-info-area">
            <div class="img">
              @if(Auth::user()->is_provider == 1)
              <img src="{{ Auth::user()->photo ? asset(Auth::user()->photo):asset('assets/images/noimage.png') }}" alt="" style="width: 141px;border-radius: 20px;">
              @else
              <img src="{{ Auth::user()->photo ? asset('assets/images/users/'.Auth::user()->photo ):asset('assets/images/noimage.png') }}"  style="width: 141px;border-radius: 20px;" alt="">
              @endif
            </div>
            <ul class="links">
                @php 

                  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                  {
                    $link = "https"; 
                  }
                  else
                  {
                    $link = "http"; 
                      
                    // Here append the common URL characters. 
                    $link .= "://"; 
                      
                    // Append the host(domain name, ip) to the URL. 
                    $link .= $_SERVER['HTTP_HOST']; 
                      
                    // Append the requested resource location to the URL 
                    $link .= $_SERVER['REQUEST_URI']; 
                  }      

                @endphp
              <li class="{{ $link == route('user-dashboard') ? 'active':'' }}">
                <a href="{{ route('user-dashboard') }}">
                Dashboard
                </a>
              </li>
              
              <li class="{{ $link == route('user-orders') ? 'active':'' }}">
                <a href="{{ route('user-orders') }}">
                Purchased Items
                </a>
              </li>

              @if($gs->is_affilate == 1)



              @endif


              <li class="{{ $link == route('user-profile') ? 'active':'' }}">
                <a href="{{ route('user-profile') }}">
                Edit Profile
                </a>
              </li>
              <li class="{{ $link == route('user-shipping-address') ? 'active':'' }}">
                <a href="{{ route('user-shipping-address') }}">
                  Shipping Address
                </a>
              </li>

              <li class="{{ $link == route('user-reset') ? 'active':'' }}">
                <a href="{{ route('user-reset') }}">
                Reset Password
                </a>
              </li>

              <li class="{{ $link == route('user-message-index') ? 'active':'' }}">
                <a href="{{ route('user-message-index') }}">
                 Messages
                 <i class="fa fa-envelope float-right text-center" style="padding:0.775rem"> 
                 <em style="text-decoration: none;">
                @if(Auth::user())
                  @php
                  $messagecount = DB::table('admin_user_conversations')
                       ->select(DB::raw('count(*) AS user_id'))
                       ->where('user_id', '=', Auth::user()->id)
                       ->get(  );
                  @endphp
                  {{ $messagecount ? $messagecount[0]->user_id : '0' }}
                 @else
                  0
                 @endif
              </em></i>
                </a>
              </li>

              <li>
                <a href="{{ route('user-logout') }}">
                  Logout
                </a>
              </li>

            </ul>
          </div>
          <?php
         // print_r($user);
          ?>
        </div>