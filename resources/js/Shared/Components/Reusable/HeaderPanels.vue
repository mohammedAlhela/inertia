<template>
    <section>

        <Head>
            <title>{{ headerData.title }}</title>
        </Head>
        <div class="panels">

            <div class="links">
                <Link href="/">
                <v-icon>mdi-home</v-icon>

                <span>Home </span> </Link>

                =>
                <Link :href="headerData.link.src">
                <v-icon>{{ headerData.link.icon }}</v-icon>
                <span>{{ headerData.link.paragraph }}</span> </Link>

            </div>

            <div class="hr"></div>

            <div class="title">
               {{ headerData.title }}


                <Link class="text-link" :href="headerData.add.src"> <v-btn v-if="headerData.add.visibility"> {{
                    headerData.add.paragraph
                }} </v-btn> </Link>
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
