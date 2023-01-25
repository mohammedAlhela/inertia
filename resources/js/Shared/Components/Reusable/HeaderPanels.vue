<template>
    <section>

        <Head>
            <title>{{ headerData.pageTitle }}</title>
        </Head>
        <div class="panels">

            <div class="links">
                <Link href="/">
                <v-icon>mdi-home</v-icon>

                <span>Home </span> </Link>

                =>
                <Link v-for="(item, index) in headerData.links" :key="index" :href="item.src">
                <v-icon>{{ item.icon }}</v-icon>
                <span>{{ item.paragraph }}</span> <span v-if="headerData.links.length - index != 1"> => </span></Link>

            </div>

            <div class="hr"></div>

            <div class="title">
                {{ headerData.title }}




            </div>
        </div>
    </section>
</template>


<script>
export default {
    props: {
        headerData: Object
    }
}
</script>
