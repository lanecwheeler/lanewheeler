<template>
    <div class="wrapper">
        <div class="social-bar" v-for="social in socials" :style="'background-image: url(' + social.photo + '); background-position: ' + social.pos + ';'">
            <a :href="social.url" target="_blank">
                <div class="shade" :data-service="social.title">{{social.title}}</div>
            </a>
        </div>
    </div>
</template>

<script>

    export default {
        data() {
            return {
                socials: [
                    {
                        title: 'Facebook',
                        url: 'https://www.facebook.com/lanecwheeler',
                        photo: '/img/me-and-the-fam.jpg',
                        pos: '50% 30%',
                    }, {
                        title: 'Twitter',
                        url: 'https://twitter.com/lanecwheeler',
                        photo: '/img/me-and-the-pres.jpeg',
                        pos: '70% 50%',
                    }, {
                        title: 'Instagram',
                        url: 'https://www.instagram.com/lanecwheeler/',
                        photo: '/img/me-and-the-boys.jpg',
                        pos: '60% 60%',
                    }, {
                        title: 'Linkedin',
                        url: 'https://www.linkedin.com/in/lanecwheeler/',
                        photo: '/img/me-cute.jpg',
                        pos: '50% 40%',
                    },
                ],
            }
        },
        computed: {

        },
        methods: {

        },
        mounted() {

        }
    }
</script>

<style lang="scss" scoped>
    $md-bp: 1000px;
    $sm-bp: 768px;
    $xs-bp: 650px;

    .wrapper {
        display: flex;
        flex-direction: column;
    }

    .social-bar {
        flex: 1 0 auto;
        background-size: cover;
        position: relative;
        display: flex;

        a {
            width: 100%;
            height: 100%;
        }

        &:hover .shade{
            left: calc(100% - 1.5em);

            &[data-service="Facebook"], &[data-service="Twitter"], &[data-service="Instagram"], &[data-service="Linkedin"] {
                background: rgba(0,0,0,1);
            }

        }

        .shade {
            position: absolute;
            text-orientation: upright;
            writing-mode: vertical-lr;
            height: 100%;
            color: rgba(255,255,255,1);
            left: 0;
            padding: .25em;
            font-family: "Bebas Neue", "sans-serif";
            font-size: 1.25em;
            text-decoration: none;
            text-align: center;
            max-width: 50vw;
            width: 100%;
            transition: all .3s ease;

            @media (max-width: $xs-bp) {
                max-width: 100vw;
            }

            &[data-service="Facebook"] {
                background: rgba(59, 89, 152, .75);
                /*background: linear-gradient(90deg, rgba(59,89,152,1) 0%, rgba(59,89,152,1) 10%, rgba(0,0,0,1) 100%);*/
            }

            &[data-service="Twitter"] {
                /*background: rgba(255,255,255,.25);*/
                background: rgba(29, 161, 242, .75);
                /*background: linear-gradient(90deg, rgba(29,161,242,1) 0%, rgba(29,161,242,1) 10%, rgba(0,0,0,1) 100%);*/
            }

            &[data-service="Instagram"] {
                background: rgba(237, 73, 86, .75);
                /*background: linear-gradient(90deg, rgba(237,73,86,1) 0%, rgba(237,73,86,1) 10%, rgba(0,0,0,1) 100%);*/
            }

            &[data-service="Linkedin"] {
                background: rgba(0, 115, 177, .75);
                /*background: linear-gradient(90deg, rgba(0,115,177,1) 0%, rgba(0,115,177,1) 10%, rgba(0,0,0,1) 100%);*/
            }
        }
    }
</style>