<!DOCTYPE html>
<html lang="zxx">
@include('frontend.components.head')

<body>
    @include('frontend.components.menu-top')
    @include('frontend.components.header')
    <!-- Shop Cart Section Begin -->

    <section class="vh-100">
        <div class="container h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-6">
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.svg"
                        class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
                    <div>
                        <h4 class="text-center mb-3">
                            Đăng nhập tài khoản
                        </h4>
                    </div>
                    <form action="{{route('web.login.user')}}" method="POST">
                        @csrf
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form1Example13">Email address</label>
                            <input type="email" id="form1Example13" class="form-control form-control-lg" name="email" />
                        </div>
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="form1Example23">Password</label>
                            <input type="password" id="form1Example23" class="form-control form-control-lg" name="password" />
                        </div>
                        <div class="d-flex justify-content-around align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="form1Example3"
                                    checked />
                                <label class="form-check-label" for="form1Example3"> Remember me </label>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                            class="btn btn-primary btn-lg btn-block">Sign in</button>
                        <p>Đăng kí tài khoản? <a href="/register">Tạo tài khoản</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <!-- Discount Section End -->

    <!-- Services Section Begin -->

    <!-- Services Section End -->

    <!-- Footer Section Begin -->
    @include('frontend.components.footer')

    <!-- Footer Section End -->
    <!-- Js Plugins -->
    @include('frontend.components.script')
</body>

</html>
