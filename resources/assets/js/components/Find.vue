<template>
    <div class="find">
        <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" @select="handleSelect">
            <router-link to="/"><el-menu-item index="1">首页</el-menu-item></router-link>
            <router-link to="/find"><el-menu-item index="2">发现</el-menu-item></router-link>
            <router-link to="/choice"><el-menu-item index="3">精选</el-menu-item></router-link>
            <router-link to="/my"><el-menu-item index="4">我的</el-menu-item></router-link>
        </el-menu>
        <div class="tag-list" v-if="flag">
            <div class="tag" v-for="tag in tags">
                <img height="240px" :src="'/images/'+tag+'.jpg'"/>
                <div class="tag-content" v-on:click="handleClick(tag)">{{ tag }}</div>
            </div>
        </div>
        <div class="picture-list" v-else>
            <div class="picture" v-model="pictures" v-for="picture in pictures">
                <img height="280px" :src=picture.picture_content>
                <router-link :to="{name:'picture-detail',params:{id:picture.pictureid}}">
                    <div class="picture-detail"></div>
                </router-link>
                <div class="picture-content" @mouseenter="enter(picture.pictureid)" @click="likeThisPicture(picture.pictureid)">
                    <div class="liked" v-if="isliked"><i class="el-icon-star-on"></i></div>
                    <div class="not-liked" v-else><i class="el-icon-star-off"></i></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/ecmascript-6">
    export default {
        data () {
            return {
                activeIndex: '2',
                tags:  [
                    '人像', '城市', '旅行', '纪实',
                    '街拍', '人文', '美女', '建筑', '自然',
                    '秋天', '静物', '光影', '夜景', '少女',
                    '儿童', '植物', '生活', '花卉', '动物',
                    '校园', '私房', '风格', '夕阳', '美食'
                ],
                pictures: [],
                flag: true,
                likepicture: {},
                isliked: false
            }
        },
        methods: {
            handleClick:function($tag) {
                this.$http.get('/find/tag=' + $tag).then((response) => {
                    response = response.body;
                    this.pictures = response.data
                });
                this.flag=false;
            },
            handleSelect(key, keyPath) {
                this.pictures=[];
                this.flag=true;
            },
            enter: function($id){
                this.$http.get('/pictures/pictureid=' + $id).then((response) => {
                    this.likepicture = response.body;
                    this.isliked = this.likepicture.userid !== 0;
                });
            },
            likeThisPicture: function($id){
                this.$http.post('/like/picture', {
                    pictureid: $id,
                    isLiked: this.isliked
                },{
                    emulateJSON: true
                });
                this.isliked = !this.isliked;
            }
        }
    }
</script>

<style lang="stylus" rel="stylesheet/stylus">
    .find
        background-color #F4F8DF
        .tag-list
            background-color #fff
            padding 30px 20px
            .tag
                border-radius 5px
                overflow hidden
                width 360px
                height 240px
                display inline-block
                margin 10px 10px
                position relative
                .tag-content
                    position absolute
                    height 240px
                    width 360px
                    text-align center
                    line-height 240px
                    z-index 1
                    left 0
                    top 0
                    font-size 0
                .tag-content:hover {
                    position absolute
                    height 240px
                    width 360px
                    text-align center
                    line-height 240px
                    z-index 1
                    left 0
                    top 0
                    font-size 20px
                    color #777777
                    background-color:rgba(211,211,211,0.5)
                }
        .picture-list
            background-color #fff
            padding 30px 20px
            .picture
                display inline-block
                margin 10px 10px
                height 280px
                border-radius 5px
                overflow hidden
                position relative
                .img
                    margin 0
                .picture-detail
                    position absolute
                    width 90%
                    height 280px
                    z-index 1
                    left 0
                    top 0
                    font-size 0
                .picture-content
                    position absolute
                    height 280px
                    width 10%
                    z-index 1
                    left 90%
                    top 0
                    font-size 0
                    .liked
                        position absolute
                        width 20px
                        margin 0
                        line-height 20px
                        z-index 1
                        left 0
                        top 90%
                        font-size 0
                    .liked:hover {
                        position absolute
                        width 20px
                        margin 0
                        line-height 20px
                        z-index 1
                        left 0
                        top 90%
                        font-size 20px
                    }
                    .not-liked
                        position absolute
                        width 20px
                        margin 0
                        line-height 20px
                        z-index 1
                        left 0
                        top 90%
                        font-size 0
                    .not-liked:hover {
                        position absolute
                        width 20px
                        margin 0
                        line-height 20px
                        z-index 1
                        left 0
                        top 90%
                        font-size 20px
                    }
</style>
