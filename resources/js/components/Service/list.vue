<template>
    <div class="list">
        <ul>
            <li v-for="item in list" :class="{ active: item.visitor_id === active }" @click="selectHandle(item.visitor_id)">
                <img class="avatar"  width="30" height="30" :alt="item.name" :src="item.avatar">
                <p class="name">{{item.name}}</p>
                <span class="time">{{item.lasted_at}}</span>
            </li>
        </ul>
    </div>
</template>
<script>

    import { indexVisit } from '../../api/visit'
    export default {
        data(){
            return {
                meta: {
                    size: 5,
                    lasted_at: 'DESC'
                },
                active: '',
                list: [],
            }
        },
        created(){
            this.active = this.$route.query.vid
            this.getLastVisitor()
        },
        watch: {
            '$route'(to, from) {
                this.active = to.query.vid
            }
        },
        methods: {
            // 访客列表
            getLastVisitor(){
                indexVisit(this.meta).then(ret => {
                    this.list = ret.data
                }).catch()
            },
            // 查看选中
            selectHandle(vid){
                this.$router.push({ path: '/service', query: { vid: vid }})
            }
        }
    };
</script>
<style scoped lang="less">
    .list {
        height: 600px;
        border:  solid 1px #EBEBEB;

        li {
            padding: 12px 15px;
            border-bottom: 1px solid #EBEBEB;
            cursor: pointer;
            transition: background-color .1s;

            &:hover {
                background-color: #E7E7E7;
                border-left: 2px solid #31449E;
            }
            &.active {
                background-color: #E7E7E7;
                border-left: 2px solid #31449E;
            }
        }
        .avatar, .name {
            vertical-align: middle;
        }
        .avatar {
            border-radius: 2px;
        }
        .name {
            display: inline-block;
            margin: 0 0 0 15px;
        }
        .time {
            float: right;
            margin: 15px;
            font-size: 13px;
        }
    }
</style>