<script>
    export default {
        data() {
            return {
                isChanging: false,
                control: null,
                text: ''
            }
        },
        replace: true,
        inherit: false,
        template: '<textarea v-model="text" class="form-control" :name="name"></textarea>',
        props: {
            value: {
                required: false
            },
            language: {
                type: String,
                required: false,
                default: 'zh-CN'
            },
            height: {
                type: Number,
                required: false,
                default: 300
            },
            minHeight: {
                type: Number,
                required: false,
                default:300
            },
            maxHeight: {
                type: Number,
                required: false,
                default: 800
            },
            name: {
                type: String,
                required: false,
                default: ''
            },
            toolbar: {
                type: Array,
                required: false,
                default() {
                    return [
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ["fontsize", "color", 'height']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        //['color', ['color']],
                        ['insert', ['link', 'picture', 'hr']]
                    ];
                }
            }
        },
        watch: {
            text(val) {
                this.$emit('input', val)
            },
            value(newVal) {
                this.text = newVal;
                if (this.minHeight > this.height) {
                    this.minHeight = this.height;
                }
                if (this.maxHeight < this.height) {
                    this.maxHeight = this.height;
                }

                var that = this;

                this.control =  $(this.$el);
                this.control.summernote({
                    fontNames: ['微软雅黑', '宋体', '黑体', '新宋体', '仿宋', '楷体', '华文宋体', '华文黑体', '华文楷体', '华文仿宋', '华文细黑'],
                    lang: this.language,
                    height: this.height,
                    minHeight: this.minHeight,
                    maxHeight: this.maxHeight,
                    toolbar: this.toolbar,
                    dialogsInBody : true,
                    callbacks: {
                        onInit: function() {
                            that.control.summernote('code', that.text);
                            that.control.summernote("fontName", '微软雅黑');
                        },
                        onImageUpload: function(files) {
                            //上传图片到服务器，使用了formData对象，至于兼容性...据说对低版本IE不太友好
                            var formData = new FormData();
                            formData.append('file',files[0]);
                            $.ajax({
                                url : '/article/uploadImg',//后台文件上传接口
                                type : 'POST',
                                data : formData,
                                beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN',$('meta[name="csrf"]').attr('content'))},
                                processData : false,
                                contentType : false,
                                dataType: "json",
                                success : function(data) {
                                    console.log(data);
                                    if(data.status==1){
                                        that.control.summernote('insertImage',data.href,'img');
                                    }else{
                                        that.$message(data.msg);
                                    }
                                },
                                errot : function(){
                                    alert('上传失败');
                                }
                            });
                        }
                    }
                }).on('summernote.change', function() {
                    if (!that.isChanging) {
                        that.isChanging = true;
                        var code = that.control.summernote('code');
                        that.text = (code === null || code.length === 0 ? null : code);
                        that.$nextTick(function() {
                            that.isChanging = false;
                        });
                    }
                });
            }
        },
    };
</script>