<!DOCTYPE html>
<html lang="zxx">
@include('frontend.components.head')

<body>
    @include('frontend.components.menu-top')
    @include('frontend.components.header')
    <!-- Shop Cart Section Begin -->

    <section class="vh-100" style="margin-bottom: 100px;">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">Đăng kí tài khoản</h3>
                            <form action="{{ route('web.post.register') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="firstName">name</label>
                                            <input type="text" id="firstName" class="form-control form-control-lg"
                                                name="name" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="lastName">email</label>
                                            <input type="email" id="lastName" class="form-control form-control-lg"
                                                name="email" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 d-flex align-items-center">
                                        <div data-mdb-input-init class="form-outline datepicker w-100">
                                            <label for="birthdayDate" class="form-label">Ngày sinh</label>
                                            <input type="date" class="form-control form-control-lg"
                                                id="birthdayDate" name="birthday"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-4 pb-2">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="phone">Số điện thoại</label>
                                            <input type="text" id="phone" class="form-control form-control-lg" name="phone" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-4 pb-2">
                                        <div data-mdb-input-init class="form-outline">
                                            <label class="form-label" for="password">Mật khẩu</label>
                                            <input type="text" id="password" class="form-control form-control-lg" name="password" />
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 pt-2"
                                    style="display: flex;
                                justify-content: end;">
                                    <button type="submit" class="btn btn-primary">Đăng
                                        kí tài khoản</button>
                                </div>
                            </form>
                        </div>
                    </div>
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
