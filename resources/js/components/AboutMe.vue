<template>
    <div class="wrapper">
        <div class="photo" :style="'background-image: url(' + photoUrl + ')'">
            <div class="img-wrapper">
                <img src="/svg/stroke.svg">
            </div>
        </div>
        <div class="text">
            <h1 class="sphereBaseHue">{{title}}
                <span class="stroke">{{title}}</span>
            </h1>
            <p> <span class="emphasized">First, I am follower of Jesus.</span>
                I believe that Jesus loves us all and can't wait to have a relationship with us.
                It is my goal to show as many people that relationship as I can through my daily interactions and work ethic.

             <span class="emphasized">Second, I am a developer.</span>
                I am a full stack developer with an emphasis in PHP (preferably Laravel flavored) and Vue.
                I am proficient with HTML, CSS, Javascript, and the occasional witty remark.
                I'm a lover of free-hand CSS, an evangelist of accessibility, and am practically head over heels for good user-centric design.
                But I'm not just a front-end art monkey, I am also familiar with Docker, Ubuntu, and can write a mean SQL statement.
                In short, I'm pretty dangerous with a Vim editor (Emacs fanboys can see themselves out).

             <span class="emphasized">Finally, I'm an artist.</span>
                Now, I'm <em>not</em> talking about making the next Mona Lisa (which, c'mon. She's really not <em>that</em> impressive).
                My art is creating websites that feel good and look good.
                I am well versed in Photoshop and Illustrator (what can I say, Adobe makes a good product)
                and do a modicum of (average) art with them in my free time. This and I do quite a bit of music. Not really relevant, but still fun...
            </p>


            <h2 class="emphasized">TLDR; My Name is Lane, and I love this job.</h2>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                title: 'let\'s keep it short.',
                photoUrl: '/img/me-cooler.jpg',
            }
        }
    }
</script>

<style lang="scss" scoped>
    .wrapper {
        display: flex;
        justify-content: space-between;
    }
    .photo {
        background-size: cover;
        background-position: 50% 30%;
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

</style>