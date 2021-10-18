<body class="hold-transition login-page" id="parallax">
  <div class="login-box boxy">
    <div class="card">
      <div class="card-header text-center">
        <a href="index.html">
          <img
            src="<?php echo ROOT; ?>assets/img/logo.png"
            alt="F.T. Solutions Pvt. Ltd."
          />
        </a>
      </div>
      <div class="card-body pb-0">
        <form action="" method="post" id="quickForm" novalidate="novalidate">
          <div class="input-group form-group mb-3">
            <input
              type="email"
              name="username"
              id="email"
              class="form-control"
              placeholder="Email"
              pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group form-group mb-3">
            <input
              type="password"
              name="password"
              id="password"
              class="form-control"
              placeholder="Password"
            />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember" />
                <label for="remember"> Remember Me </label>
              </div>
            </div>

            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">
                Sign In
              </button>
            </div>
          </div>
        </form>
        <div class="text-center" style="color: crimson; font-style: italic; text-transform: capitalize;">
        <!-- alert: print alert message in small -->
        <small></small>
        </div>
      </div>
    </div>
  </div>
