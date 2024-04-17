<div class="row">
    <div class="col-lg-4">
        <div class="panel-head">
            <div class="panel-title">Thông tin chung</div>
            <div class="panel-description">
                <p>Nhập thông tin chung seo</p>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row mb15">
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label for=""
                                class="control-label text-left">Tiêu
                                đề seo
                                <span class="text-danger">(*)</span></label>
                            <textarea type="text" name="meta_title" value="" class="form-control text-teara-2" placeholder=""
                                autocomplete="off">{{ old('meta_title', $mode->meta_title ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label for=""
                                class="control-label text-left">Mô
                                tả
                                seo
                                <span class="text-danger">(*)</span></label>
                            <textarea type="text" id="meta_description" name="meta_description" value=""
                                class="form-control text-teara-2" placeholder="" autocomplete="off">{{ old('meta_description', $mode->meta_description ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-row">
                            <label for=""
                                class="control-label text-left">meta_keyword
                                <span class="text-danger">(*)</span></label>
                            <textarea type="text" name="meta_keyword" value="" class="form-control text-teara-2" placeholder=""
                                autocomplete="off">{{ old('meta_keyword', $mode->meta_keyword ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
</div>