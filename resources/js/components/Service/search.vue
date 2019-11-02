<template>
    <div class="card">
        <img class="avatar" width="40" height="40" alt="user.name" src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png">
        <p class="name">hello chat</p>
        <header>

        </header>
        <footer>
            <input class="search" type="text" placeholder="search user..." @keyup="onKeyup | debounce 150">
        </footer>
    </div>
</template>
<script>
    export default {
        name: 'Search',
        methods: {
            onKeyup (e) {
                this.search(e.target.value);
            }
        }
    };
</script>
<style scoped lang="less">
    .card {
        padding: 12px;
        border-bottom: solid 1px #24272C;

        footer {
            margin-top: 10px;
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
            font-size: 16px;
        }
        .search {
            padding: 0 10px;
            width: 100%;
            font-size: 12px;
            color: #fff;
            height: 30px;
            line-height: 30px;
            border: solid 1px #3a3a3a;
            border-radius: 4px;
            outline: none;
            background-color: #26292E;
        }
    }
</style>