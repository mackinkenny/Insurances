<template>
    <div class="paginator flex align-center">
        <a class="previous block" :class="{'disabled': previousPageUrl == null}" :href="previousPageUrl">
            Previous
        </a>
        <div @click="redirectTo(page)" class="page" :class="{'active-page': +page === +currentPage}"
             v-for="(page, count) in +pageCount"
             v-show="+page >= startPageShow && +page <= endPageShow"
        >
            {{page}}
        </div>
        <a class="next block" :class="{'disabled': nextPageUrl == null}" :href="nextPageUrl">
            Next
        </a>
    </div>
</template>

<script>
export default {
    name: "Paginator.vue",
    data() {
        return {
            startPageShow: 1,
            endPageShow: 5,
            showLimit: 5,
        }
    },
    created() {
        if (this.endPageShow - +this.currentPage <=  Math.floor(this.showLimit / 2)) {
            const startPage = this.startPageShow + this.currentPage - Math.floor(this.showLimit / 2);
            const endPage = this.endPageShow + this.currentPage - Math.floor(this.showLimit / 2);
            if (endPage <= +this.pageCount && endPage - startPage + 1 === +this.showLimit) {
                this.startPageShow = startPage;
                this.endPageShow = endPage;
            } else {
                this.startPageShow += +this.pageCount - this.showLimit;
                this.endPageShow = +this.pageCount;
            }
        }
    },
    props: {
        pageCount: [Number, String],
        nextPageUrl: String,
        previousPageUrl: String,
        pagination: String,
        path: String,
        currentPage: [String, Number]
    },
    methods: {
        redirectTo(page) {
            window.location = this.path + "?page=" + page;
        }
    }
}
</script>

<style scoped>
.paginator {
    font-size: .85rem;
    margin: 10px 0;
}
.paginator .page,
.paginator .previous,
.paginator .next {
    padding: 5px 10px;
    cursor: pointer;
    margin: 0 5px;
}
.active-page {
    background: #EDEBFF;
}
.previous.disabled,
.next.disabled {
    color: #eee;
}
</style>
