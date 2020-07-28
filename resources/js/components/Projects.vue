<template>
    <div class="wrapper">
<!--        <div class="photo" :style="'background-image: url(' + photoUrl + ')'">-->
        <div class="photo" :style="'background-image: url(' + topPhoto + ')'">
            <div class="img-wrapper">
                <img src="/svg/stroke.svg">
            </div>
        </div>
        <div class="text">
            <h1 class="sphereBaseHue">{{title}}
                <span class="stroke">{{title}}</span>
            </h1>
            <div class="projectWrapper">
                <div class="projControl prev" @click="prev()"><i class="fa fa-angle-right"></i></div>
                <div v-if="currentProj === i" class="majorProject" v-for="(project, i) in majorProjects">
<!--                    <div class="projTitle" :style="'background-image: url(' + project.photo + ')'">-->
                        <h2>{{project.title}}</h2>
<!--                    </div>-->
                    <div class="projContent">
                        <p class="projDesc"><span class="emphasized">desC:</span>
                            {{project.desc}}
                        </p>
                        <p class="projTech"><span class="emphasized">TECh uSed:</span>
                            {{project.techUsed}}
                        </p>
                    </div>
                    <a class="projLink" target="_blank" :href="project.url">ChEcK IT oUT</a>
                </div>
                <div v-if="currentProj === majorProjects.length" class="minorProject">
                    <h2>Other things I worked on...</h2>
                    <div v-for="(project) in minorProjects">
                        <h3>{{project.title}}</h3>
                        <a class="projLink" target="_blank" :href="project.url">ChEcK IT oUT</a>
                    </div>
                </div>
                <div class="projControl next" @click="next()"><i class="fa fa-angle-right"></i></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                title: 'look, i made these.',
                photoUrl: 'https://source.unsplash.com/collection/11521439',
                currentProj: 0,
                majorProjects: [ {
                        title: 'Joey Pepperoni',
                        url: 'https://twitter.com/AyJoeyPepperoni',
                        desc: 'A twitter that uses the Twit API to generate Italian(ish) names and tweet them at people.',
                        techUsed: ['Laravel','TwitAPI', 'Axios'],
                        photo: '/img/twitter.jpg'
                    }, {
                        title: 'Elevate Holistics',
                        url: 'https://elevate-holistics.com',
                        desc: 'A telehealth site comprised of an appointment scheduling service to the public (integrated with Acuity).' +
                            'Also contains an authenticated portal for Patients to fill out forms and monitor their request status, ' +
                            'and for Doctors to approve and automatically generate marijuana recommendations in Oklahoma and Missouri.',
                        techUsed: ['Laravel','Vue', 'Acuity API', 'Datatables', 'Medium Editor', 'Axios', 'Vue DatePicker'],
                        photo: '/svg/elevate.svg'
                    }, {
                        title: 'Enliven Wellbeing',
                        url: 'https://enlivenwellbeing.com/',
                        desc: 'A fitness initiative from Enable Midstream Partners. Admins are able to keep employees informed about ' +
                              'current fitness activities and competitions in the corporation. They are also able to chose employees to ' +
                              'be featured on the homepage.',
                        techUsed: ['Laravel','jQuery', 'Datatables'],
                        photo: '/svg/enable.svg'
                    }, {
                        title: 'Lagoon Water Solutions',
                        url: 'https://lagoonwater.com/',
                        desc: 'A brochure site to let potential clients know about their pipeline services.',
                        techUsed: ['Laravel','Google Maps API', 'PixiJS'],
                        photo: '/svg/lagoon.svg'
                    },
                ],
                minorProjects: [ {
                        title: 'Kevin Durant - 35 Ventures',
                        url: 'https://thirtyfiveventures.com/foundation',
                    }, {
                        title: 'Blake Griffin',
                        url: 'https://blakegriffin.com/',
                    }, {
                        title: 'Groendyke Transport, Inc',
                        url: 'https://groendyke.com/',
                    }, {
                        title: 'Kirkpatrick Bank',
                        url: 'https://kirkpatrickbank.com/',
                    },
                ]
            }
        },
        computed: {
            topPhoto: function() {
                return (this.currentProj < this.majorProjects.length) ?
                    this.majorProjects[this.currentProj].photo :
                    this.photoUrl;
            }
        },
        methods: {
            getPhotoUrl() {
                alert('here');

            },
            prev() {
                (this.currentProj === 0) ?
                    this.currentProj = this.majorProjects.length :
                    this.currentProj -= 1;
            },
            next() {
                (this.currentProj === this.majorProjects.length) ?
                    this.currentProj = 0 :
                    this.currentProj += 1;
            }
        }
    }
</script>

<style lang="scss" scoped>

    $md-bp: 1000px;
    $sm-bp: 768px;
    $xs-bp: 650px;

    .wrapper {
        display: flex;
        justify-content: space-between;
    }
    .photo {
        background-size: cover;
        background-position: center;
        min-height: 30vh;
    }

    .emphasized {
        font-size: 1.5em;
    }

    p {
        line-height: 1.5em;
        letter-spacing: 0.5px;
        text-align: justify;
        vertical-align: middle;
    }

    h2.emphasized {
        font-size: 1.75em;
        text-align: center;
    }

    .text {
        display: flex;
        flex-direction: column;
    }

    .projectWrapper {
        flex: 1 0 auto;
        display: flex;
        justify-content: space-between;

        .projControl {
            display: flex;
            flex: 0 1 15px;
            height: 100%;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,.5);
            cursor: pointer;

            i {
                display: block;
                height: 15px;
                width: 15px;
                border-top: 2px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                border-left: 2px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                transition: all .3s ease;
            }

            &:hover {
                i {
                    border-top: 2px solid hsla(var(--base-hue-color), 100%, 50%, 1);
                    border-left: 2px solid hsla(var(--base-hue-color), 100%, 50%, 1);
                }
            }


            &.next i{
                transform: rotate(135deg);
                margin-left: 15px;
            }

            &.prev i{
                margin-right: 15px;
                transform: rotate(-45deg);
            }
        }

        .majorProject, .minorProject {
            /*max-width: 400px;*/
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .majorProject {
            /*border: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);*/

            h2 {
                padding-top: .5em;
                border-top: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                text-align: center;
            }
        }

        .projTitle {
            flex: 0 0 150px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-position: center;
            box-shadow: inset 0px 0px 10px 0px black;
            font-size: .75em;

            h2 {
                background: rgba(0,0,0,.75);
                margin: 0;
                padding: .5em .25em;
            }
        }

        .projContent {
            padding: 1em;
            display: flex;
            flex-direction: column;
            flex: 1 0 auto;
            overflow-y: auto;

            span.emphasized {
                font-family: "Major Mono Display", "sans-serif";
            }
        }

        .projLink {
            flex: 0 1 auto;
            padding: .5em 0;
            font-family: "Major Mono Display", "sans-serif";
            text-decoration: none;
            font-size: 1em;
            width: 100%;
            color: hsla(var(--base-hue-color), 100%, 50%, 1);
            border-top: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
            text-align: center;
            background: transparent;
            transition: all .3s ease;

            &:hover {
                color: black;
                border-top: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                background: hsla(var(--base-hue-color), 100%, 50%, 1);
            }
        }

        .minorProject {
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;

            h2 {
                border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                padding: 1em;
                font-size: 1.5em;
                margin: 0;
            }

            h3 {
                font-family: "Bebas Neue", "sans-serif";
                font-size: 1.25em;
            }

            .projLink {
                display: block;
                border: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
            }

        }
    }

    @media (max-width: $sm-bp) {
        h1 {
            z-index: 0;
        }
        .projectWrapper {
            flex-direction: row;
            flex-wrap: wrap;

            .prev, .next {
                order: 1;
                flex: 1 0 50%;
                height: auto;
                margin: .5em 0;
                z-index: 2;
            }
            .majorProject, .minorProject {
                order: 2;
                flex: 1 0 100%;
                margin: 1em 0;
            }
        }

    }

</style>