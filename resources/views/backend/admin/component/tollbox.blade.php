<div class="ibox-tools">
    <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
    </a>
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-wrench"></i>
    </a>
    <ul class="dropdown-menu dropdown-user">
        <li><a href="#" class="changeStatusAll" data-value="1" data-field="publish" data-model="User">Public toàn bộ
                thành viên</a>
        </li>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <li><a href="#" class="changeStatusAll" data-value="0" data-field="publish" data-model="User">unPublic toàn bộ thành
                viên</a>
        </li>
    </ul>
    <a class="close-link">
        <i class="fa fa-times"></i>
    </a>
</div>
