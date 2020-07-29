<!-- Use preprocessors via the lang attribute! e.g. <template lang="pug"> -->
<template>
    <div class="stage">
        <div class="container" :class="{'open' : currentSide !== 0}">
            <div class="cubebounce">
                <div :class="{'no-transition' : this.resetting }"
                     :style="'-webkit-transform: rotateX(' + x + 'deg) rotateY(' + y + 'deg) rotateZ(' + z + 'deg)'"
                     class="cube" id="cube"
                     ref="cube">
                    <div :class="'cube__face cube__face--' + section.side" v-for="section, i in sections">
                        <span>{{section.title}}</span>
                    </div>
                    <div class='wrap'>
                        <div :key="index" class='c' v-for="index in totalPoints"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav">
            <div class="hamburger-wrapper" @click="toggleNav">
                <button class="hamburger" :class="{'is-active' : navOpen, 'no-show' : currentSide === 0}" type="button">
                  <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                  </span>
                </button>
            </div>
            <!--         <i @click="rotateCube('up')" class="fas fa-angle-up"></i>
                    <i @click="rotateCube('down')" class="fas fa-angle-down"></i>
                    <i @click="rotateCube('left')" class="fas fa-angle-left"></i>
                    <i @click="rotateCube('right')" class="fas fa-angle-right"></i>
                    <i @click="resetCube" class="fas fa-redo"></i> -->
            <div class="sidelist" :class="{'no-show' : currentSide !== 0 && !navOpen, 'nav-opened' : navOpen}">
                <span @click="rotate(i)"
                      :class="{'active' : currentSide === i}"
                      v-for="section, i in sections">
                    {{i}}. {{section.title}}
                </span>
            </div>
        </div>
        <div class="content" :class="{'hidden' : currentSide === 0}">
            <transition name="fade" mode="out-in">
                <keep-alive>
                    <component :is="component"></component>
                </keep-alive>
            </transition>
        </div>
    </div>
</template>

<script>
    const Home = '';
    import AboutMe from './AboutMe';
    import Projects from './Projects';
    import ContactMe from './ContactMe';
    import ColorMatch from './ColorMatch';
    import Socials from './Socials';

    export default {
        name: 'Landing',
        data() {
            return {
                x: 0,
                y: 0,
                z: 0,
                kode: [38, 38, 40, 40, 37, 39, 37, 39, 66, 65],
                pos: 0,
                resetting: false,
                moving: false,
                sections: [
                    {title: 'heLLo.', section: '', side: 'front',}, // side 1
                    {title: 'AboUT Me', section: 'AboutMe', side: 'right',}, // side 2
                    {title: 'ProJEctS', section: 'Projects', side: 'back',}, // side 3
                    {title: 'COntaCt ME', section: 'ContactMe', side: 'left',}, // side 4
                    {title: 'ColORs GaMe', section: 'ColorMatch', side: 'top',}, // side 5
                    {title: 'SoCial MEdiA', section: 'Socials', side: 'bottom',}, // side 6
                ],
                sides: [
                    {x: 0, y: 0, z: 0}, // side 1
                    {x: 0, y: -90, z: 0}, // side 2
                    {x: 0, y: 180, z: 0}, // side 3
                    {x: 0, y: 90, z: 0}, // side 4
                    {x: -90, y: 0, z: 0}, // side 5
                    {x: 90, y: 0, z: 0} // side 6
                ],
                currentSide: 0,
                xDown: null,
                yDown: null,

                randColor: Math.random() * 180,
                totalPoints: 100,

                component: Home,
                navOpen: false,
            };
        },
        computed: {
            xAbs: function () {
                return Math.abs(this.x) % 360;
            },
            yAbs: function () {
                return Math.abs(this.y) % 360;
            },
            zAbs: function () {
                return Math.abs(this.z) % 360;
            },
        },
        components: {
            Home,
            AboutMe,
            Projects,
            ContactMe,
            ColorMatch,
            Socials,
        },
        methods: {
            toggleNav() {
                this.navOpen = !this.navOpen;
            },
            // this is for when I will eventually expand this to give the user control over the rotation via arrows
            rotateCube(dir, e) {
                if (e) var key = e.which;
                var arrow = {left: 37, up: 38, right: 39, down: 40};

                this.moving = true;
                switch (dir || key) {
                    case arrow.left:
                    case 'left':
                        this.turnLeft();
                        break;

                    case arrow.right:
                    case 'right':
                        this.turnRight();
                        break;

                    case arrow.up:
                    case 'up':
                        this.turnUp();
                        break;

                    case arrow.down:
                    case 'down':
                        this.turnDown();
                        break;
                }
                setTimeout(() => {
                    this.moving = false
                }, 1000);
            },
            isWhole(n) {
                var result = (n - Math.floor(n)) !== 0;
                if (result)
                    return false;
                else
                    return true;
            },
            turnLeft() {
                if (this.xAbs === 90) {
                    this.z -= (this.x > 0) ? -90 : 90;
                } else if (this.xAbs === 180) {
                    this.y += 90;
                } else if (this.xAbs === 270) {
                    this.z += (this.x > 0) ? -90 : 90;
                } else {
                    this.y -= 90;
                }
            },
            turnRight() {
                if (this.xAbs === 90) {
                    this.z += (this.x > 0) ? -90 : 90;
                } else if (this.xAbs === 180) {
                    this.y -= 90;
                } else if (this.xAbs === 270) {
                    this.z -= (this.x > 0) ? -90 : 90;
                } else {
                    this.y += 90;
                }
            },
            turnUp() {
                this.x += 90;
            },
            turnDown() {
                this.x -= 90;
            },

            doSecret() {
                // this.ryuStyle.left = '0';
                // this.hadoukenStyle = { opacity: '1', left: '80px' };
                // var audio = new Audio(require('./assets/hadouken.mp3'));
                // audio.play();
                // setTimeout(() => {
                //   this.hadoukenStyle.left = '110%';
                // }, 350);
                // setTimeout(() => {
                //   this.hadoukenStyle = { left: '-50px', opacity: '0' };
                //   this.ryuStyle.left = '-100px';
                // }, 1000);
                // alert('hey');

                let returnSide = this.currentSide,
                    timeout = 0;

                console.log('rs: ', returnSide);
                this.rotate(0, false);
                if (!returnSide === 0) {
                    timeout = 1000;
                    this.rotate(0, false);
                }

                setTimeout(() => {
                    this.sections[0].title = 'M\'lady.';
                    this.x -= 10;
                    this.z -= 5;
                }, timeout);

                setTimeout(() => {
                    this.rotate(returnSide, false);
                }, timeout + 1250);

                setTimeout(() => {
                    this.sections[0].title = 'heLLo.'
                }, timeout + 2250);

            },
            resetCube() {
                this.x = 0;
                this.y = 0;
                this.z = 0;
            },
            rotate(i, random = true) {
                this.navOpen = false;
                random = false;
                this.currentSide = i;
                this.component = this.sections[i].section;
                let timeout = 0;

                if (random) {
                    this.rotateRandom();
                    timeout = 1000;
                }
                setTimeout(() => {
                    this.x = this.sides[i].x;
                    this.y = this.sides[i].y;
                    this.z = this.sides[i].z;
                }, timeout);
            },
            rotateRandom() {
                let max = 10, min = -10;
                this.x += Math.random() * (max - min) + min;
                this.y += Math.random() * (max - min) + min;
                this.z += Math.random() * (max - min) + min;
            },
        },
        mounted() {
            document.addEventListener('keydown',
                (event) => {
                    // this.rotateCube(null, event);
                    if (event.keyCode === this.kode[this.pos++]) {
                        if (this.kode.length === this.pos) {
                            this.doSecret();
                            this.pos = 0;
                            return false;
                        }
                    } else {
                        this.pos = 0;
                    }
                }, false);

            var xDown = null;
            var yDown = null;

            function getTouches(evt) {
                return evt.touches ||             // browser API
                    evt.originalEvent.touches; // jQuery
            }

            function handleTouchStart(evt) {
                const firstTouch = getTouches(evt)[0];
                xDown = firstTouch.clientX;
                yDown = firstTouch.clientY;
            }

            function handleTouchMove(evt) {
                if (!xDown || !yDown) {
                    return;
                }

                var xUp = evt.touches[0].clientX;
                var yUp = evt.touches[0].clientY;

                var xDiff = xDown - xUp;
                var yDiff = yDown - yUp;

                if (Math.abs(xDiff) > Math.abs(yDiff)) {/*most significant*/
                    if (xDiff > 0) {
                        /* left swipe */
                    } else {
                        /* right swipe */
                    }
                } else {
                    if (yDiff > 0) {
                        /* up swipe */
                    } else {
                        /* down swipe */
                    }
                }
                /* reset values */
                xDown = null;
                yDown = null;
            }

        }
    }
</script>

<!-- Use preprocessors via the lang attribute! e.g. <style lang="scss"> -->
<style lang="scss">

    $md-bp: 1000px;
    $sm-bp: 768px;
    $xs-bp: 650px;

    ::-webkit-scrollbar {
        display: none;
    }

    html, body {
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .stage {
        overflow: hidden;
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background: radial-gradient(circle, rgba(34, 34, 34, 1) 0%, rgba(3, 3, 6, 1) 62%, rgba(0, 0, 0, 1) 100%);
    }

    .container {
        overflow: hidden;
        height: 100vh;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        perspective: 500px;
        font-family: sans-serif;
        transition: all 1s ease;
        max-width: 100vw;

        &.open {
            max-width: 50vw;
        }

        @media (max-width: $xs-bp) {
            &.open {
                max-width: 0;
            }
        }
    }

    .content {
        right: 1em;
        background: rgba(0,0,0,1);
        color: white;
        font-family: sans-serif;
        flex: 1 0 50%;
        transition: all 1s ease;
        box-shadow: -5px 0px 25px 0px black;
        max-width: 50vw;

        @media (max-width: $xs-bp) {
            max-width: 100vw;
        }

        & > div {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .photo {
            flex: 1 0 30%;
            position: relative;

            @media (min-width: 1400px) {
                min-height: 400px;
            }

            .img-wrapper {
                width: 100%;
                height: 100%;
                overflow: hidden;
                position: relative;
            }

            img {
                position: absolute;
                bottom: -30%;
                left: -50%;
                width: 100vw;
            }

            &:after {
                content: ' ';
                display: block;
                position: absolute;
                bottom: -50;
                left: 0;
                width: 100%;
                height: 50px;
                background: linear-gradient(180deg, rgba(0,0,0,1) 0%, rgba(0,0,0,0) 100%);
                z-index: 3;
            }
        }

        .text {
            flex: 0 1 70%;
            padding: 3em 2em 2em 2em;
            overflow: scroll;
            position: relative;
        }

        h1, h2 {
            /*font-family: "Bebas Neue", sans-serif;*/
            font-family: "Major Mono Display", sans-serif;
            /*text-transform: uppercase;*/
            position: relative;
            z-index: 2;
            color: hsla(var(--base-hue-color), 100%, 50%, 1);
            font-size: 2.5em;
            letter-spacing: 5px;
            margin-top: 0;

            @media (max-width: $md-bp) {
                font-size: 2em;
            }

            @media (max-width: $sm-bp) {
                font-size: 1.5em;
            }

            @media (max-width: $xs-bp) {
                font-size: 1.25em;
            }

            span.stroke {
                position: absolute;
                color: transparent;
                -webkit-text-stroke: 0.1px rgba(255,255,255,.1);
                transform: scale(1.25);
                z-index: -1;
                top: 0.25em;
                left: 1em;
            }
        }

        .emphasized {
            color: hsla(var(--base-hue-color), 100%, 50%, 1);
            font-size: 1.25em;
            font-weight: 700;
        }
    }

    .cubebounce {
        transform-style: preserve-3d;
        animation: float 8s infinite linear;
    }

    .cube {
        width: 200px;
        height: 200px;
        position: relative;
        transform-style: preserve-3d;
        transition: transform 1s ease;

        .cube__face {
            position: absolute;
            width: 100%;
            height: 100%;
            /*border: 1px solid rgba(255, 255, 255, .25);*/
            border: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
            color: rgba(255, 255, 255, .75);
            font-family: 'Major Mono Display', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(10, 10, 10, .25);
            transition: background .2s ease;

            &.cube__face--front {
                transform: rotateY(0deg) translateZ(100px);
            }

            &.cube__face--right {
                transform: rotateY(90deg) translateZ(100px);
            }

            &.cube__face--back {
                transform: rotateY(180deg) translateZ(100px);
            }

            &.cube__face--left {
                transform: rotateY(-90deg) translateZ(100px);
            }

            &.cube__face--top {
                transform: rotateX(90deg) translateZ(100px);
            }

            &.cube__face--bottom {
                transform: rotateX(-90deg) translateZ(100px);
            }

            span {
                background: rgba(0, 0, 0, 1);
                padding: .25em;
            }
        }
    }

    @keyframes float {
        0% {
            transform: translatey(0px) translatex(0px);
        }
        25% {
            transform: translatey(-5px) translatex(2px) translatez(2px);
        }
        50% {
            transform: translatey(0px);
        }
        75% {
            transform: translatey(5px) translatex(-2px) translatez(-2px);
        }
        100% {
            transform: translatey(0px);
        }
    }

    // begin particle sphere
    $total: 300; // total particles
    $orb-size: 75px;
    $particle-size: 2px;
    $time: 14s;

    /*.sphereBaseHue {*/
    /*    color: hsla(var(--base-hue-color), 100%, 50%, 1);*/
    /*}*/

    .wrap {
        position: relative;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        transform-style: preserve-3d;
        perspective: 1000px;
        animation: rotate $time infinite linear; // rotate orb
    }

    @keyframes rotate {
        100% {
            transform: rotateY(360deg) rotateX(360deg);
        }
    }

    .c {
        position: absolute;
        width: $particle-size;
        height: $particle-size;
        depth: $particle-size;
        border-radius: 50%;
        opacity: 0;
    }

    @for $i from 1 through $total {
        $z: (random(360) * 1deg); // random angle to rotateZ
        $y: (random(360) * 1deg); // random to rotateX

        .c:nth-child(#{$i}) { // grab the nth particle
            animation: orbit#{$i} $time infinite;
            animation-delay: ($i * .01s);
            background-color: hsla(calc((40/var(--total) * #{$i}) + var(--base-hue-color)), 100%, 50%, 1);
        }

        @keyframes orbit#{$i}{
            20% {
                opacity: 1; // fade in
            }
            30% {
                transform: rotateZ(-$z) rotateY($y) translateX($orb-size) rotateZ($z); // form orb
            }
            80% {
                transform: rotateZ(-$z) rotateY($y) translateX($orb-size) rotateZ($z); // hold orb state 30-80
                opacity: 1; // hold opacity 20-80
            }
            100% {
                transform: rotateZ(-$z) rotateY($y) translateX(($orb-size * .75)) rotateZ($z); // translateX * 3
            }
        }
    }

    .nav {
        position: fixed;
        top: 0;
        width: 100%;
        /*height: 100vh;*/
        z-index: 2;

        .hamburger-wrapper {
            transition: all .3s ease;
        }

        .hamburger {
            padding: 15px 15px;
            cursor: pointer;
            transition: opacity .15s linear, filter .15s linear, top .3s ease;
            font: inherit;
            color: inherit;
            text-transform: none;
            background-color: rgba(0,0,0,1);
            border: 0;
            margin: 0;
            overflow: visible;

            position: absolute;
            top: 0;
            right: 0;
            outline: none;
            display: none;

            @media (max-width: $xs-bp) {
                display: inline-block;
            }

            &:hover {
                opacity: 1;
            }

            &.is-active {

                &:hover {
                    opacity: 1;
                }

                .hamburger-inner {
                    background-color: hsla(var(--base-hue-color), 100%, 50%, 1);
                }

                .hamburger-inner::before,
                .hamburger-inner::after {
                    background-color: transparent;
                }
            }
        }

        .hamburger-box {
            width: 30px;
            height: 22px;
            display: inline-block;
            position: relative;
        }

        .hamburger-inner {
            display: block;
            top: 50%;
            margin-top: -2px;

            &, &::before, &::after {
                width: 30px;
                height: 2px;
                background-color: hsla(var(--base-hue-color), 100%, 50%, 1);
                border-radius: 0;
                position: absolute;
                transition-property: transform;
                transition-duration: 0.15s;
                transition-timing-function: ease;
                transition: all .3s ease;
            }

            &::before, &::after {
                content: "";
                display: block;
            }

            &::before {
                top: -10px;
            }

            &::after {
                bottom: -10px;
            }
        }

        i {
            color: rgba(255, 255, 255, .5);
            font-size: 32px;
            position: absolute;
            cursor: pointer;
        }

        .fas {
            font-family: 'Font Awesome\ 5 Free';

            &.fa-angle- {
                &up {
                    top: 10px;
                    right: calc(50% - .5em);
                }

                &down {
                    bottom: 10px;
                    right: calc(50% - .5em);
                }

                &left {
                    left: 10px;
                    top: calc(50% - .5em);
                }

                &right {
                    right: 10px;
                    top: calc(50% - .5em);
                }
            }

            &.fa-redo {
                right: 10px;
                bottom: 10px;
            }
        }
    }

    .no-transition {
        transition: none !important;
    }

    .sidelist {
        position: absolute;
        padding: 1.5em;
        top: 0;
        left: 0;
        z-index: 3;
        transition: all .3s ease;

        @media (max-width: $xs-bp) {
            font-size: 1em;
        }

        &.nav-opened {
            background: rgba(0,0,0,1);
        }

        span {
            display: block;
            font-family: 'Major Mono Display', monospace;
            color: rgba(255, 255, 255, .3);
            cursor: pointer;
            transition: all .3s ease;
            line-height: 1.25em;

            &.active {
                color: hsla(var(--base-hue-color), 100%, 50%, .5);
            }

            &:hover {
                color: hsla(var(--base-hue-color), 100%, 50%, 1);
            }
        }
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }

    .hidden {
        flex: 0 0 0;
        opacity: 0;
        max-width: 0;
        overflow: hidden;
    }

    @media (max-width: $xs-bp) {
        .no-show {
            top: -50vh !important;
        }
    }

</style>