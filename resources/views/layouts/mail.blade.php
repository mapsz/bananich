    <!-- Mail -->
    <div style="position: relative;width:100%;margin: auto">
      
      <!-- Header -->
      <div style="
        display:flex;
        justify-content: space-between;
        align-items: center;
        width: 600px;
        height: 160px;
        margin: auto;
        background: #FBD610;
      ">
        <span style="
          display: flex;
          flex-direction: column;
          padding-left: 50px;
          font-family: Open Sans;
          font-style: normal;
          font-size: 30px;
          line-height: 100%;
          color: #000000;
        ">
          <span><b>Бананыч.</b></span>  
          <span>Доставка полезного</span>  
        </span>
        <span class="header-image" style="
          width: 160px;
          height: 160px;
          background: url('http://bananich.ru/mail/banana.png');
          background-repeat: round;        
        "></span>
      </div>
      
      <!-- Content -->
      <div style='
        box-sizing: border-box;
        width: 600px;
        margin: auto;
        border: 1px #fbd610 solid;
        border-top: 0px;  
        border-bottom: 0px;  
        padding: 10px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
      '>
        <div style="
          margin: 10px;
          padding: 20px 0px;
          border: 1px solid #828282;
          border-left: 0px;
          border-right: 0px;
        ">

          @yield('content')

        </div>
      </div>
      

      <!-- Footer -->
      <div style="
        box-sizing: border-box;
        width: 600px;
        margin: auto;
        border: 1px #fbd610 solid;
        border-top: 0px;  
        padding: 10px;"
      >
        <div style="
          display: flex;
          justify-content: space-around;"
        >
          <!-- text -->
          <span style="
            display:flex;
            flex-direction:column;
          ">
            <span>
              <b>
                Пишите или звоните,
                мы всегда рады общению!
              </b>
            </span>
            <span>
              Ваш Бананыч
            </span>

          </span>
          <!-- links -->
          <span >
            <!-- Socs -->
            <div style="
              display:flex;
            ">
              <a href="https://instagram.com/bananich.ru" target="_blank">
                <img src="http://bananich.ru/image/insta.svg" alt="" style="margin-right: 10px;">
              </a>
              <a href="https://vk.com/bananichru" target="_blank">
                <img src="http://bananich.ru/image/vk.svg" alt="">
              </a>
            </div>
            <a href="https://bananich.ru">bananich.ru</a>
            
          </span>
        </div>

        <!-- Unfollow -->
        <div style="  
          display: flex;
          justify-content: center;
        ">
          <a href="https://bananich.ru/unsubscribe">Отписаться</a>
        </div>
      </div>

    </div>