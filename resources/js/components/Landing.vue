<!-- Use preprocessors via the lang attribute! e.g. <template lang="pug"> -->
<template>
    <div class="stage">
        <div class="container">
            <div class="cubebounce">
                <div :class="{'no-transition' : this.resetting }"
                     :style="'-webkit-transform: rotateX(' + x + 'deg) rotateY(' + y + 'deg) rotateZ(' + z + 'deg)'"
                     class="cube" id="cube"
                     ref="cube">
                    <div :class="'cube__face cube__face--' + section.side" v-for="section, i in sections">
                        <span>{{section.title}}</span>
                    </div>
                    <div class='wrap'>
                        <div :key="index" class='c' v-for="index in 300"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrows">
            <!--         <i @click="rotateCube('up')" class="fas fa-angle-up"></i>
                    <i @click="rotateCube('down')" class="fas fa-angle-down"></i>
                    <i @click="rotateCube('left')" class="fas fa-angle-left"></i>
                    <i @click="rotateCube('right')" class="fas fa-angle-right"></i>
                    <i @click="resetCube" class="fas fa-redo"></i> -->
            <div class="sidelist">
                <span @click="rotate(i)" v-for="section, i in sections">{{i}}. {{section.title}}</span>
            </div>
        </div>
        <div class="content">
            <transition name="fade" mode="out-in">
                <component :is="component"></component>
            </transition>
        </div>
    </div>
</template>

<script>
    const Home = '';
    import AboutMe from './AboutMe';
    import Projects from './Projects';
    import ContactMe from './Projects';
    import Toolkit from './Projects';
    import Gallery from './Projects';

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
                    {title: 'hello.', section: '', side: 'front',}, // side 1
                    {title: 'About Me', section: 'AboutMe', side: 'right',}, // side 2
                    {title: 'Projects', section: 'Projects', side: 'back',}, // side 3
                    {title: 'Contact Me', section: 'ContactMe', side: 'left',}, // side 4
                    {title: 'Toolkit', section: 'Toolkit', side: 'top',}, // side 5
                    {title: 'Gallery', section: 'Gallery', side: 'bottom',}, // side 6
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

                component: Home,
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
            Toolkit,
            Gallery,
        },
        methods: {
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
                    this.sections[0].title = 'hello.'
                }, timeout + 2250);

            },
            resetCube() {
                this.x = 0;
                this.y = 0;
                this.z = 0;
            },
            rotate(i, random = true) {
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
        background: radial-gradient(circle, rgba(34, 34, 34, 1) 0%, rgba(3, 3, 6, 1) 62%, rgba(0, 0, 0, 1) 100%);
        perspective: 500px;
        font-family: sans-serif;
        transition: all .3s ease;

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
        // transform: rotateX(45deg) rotateY(45deg) rotateZ(30deg);
        // animation: float 5s infinite linear;

        .cube__face {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 1px solid rgba(255, 255, 255, .25);
            color: rgba(255, 255, 255, .75);
            font-family: 'Major Mono Display', monospace;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(10, 10, 10, .55);
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
    $total: 100; // total particles
    $orb-size: 75px;
    $particle-size: 1px;
    $time: 14s;
    $base-hue: random(180); // change for diff colors (180 is nice)

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
        $hue: ((40/$total * $i) + $base-hue); // set hue

        .c:nth-child(#{$i}) { // grab the nth particle
            animation: orbit#{$i} $time infinite;
            animation-delay: ($i * .01s);
            background-color: hsla($hue, 100%, 50%, 1);
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

    .arrows {
        position: fixed;
        top: 0;
        width: 100%;
        height: 100vh;
        z-index: 2;

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

    .swing-pers {
        perspective: 2000px;
    }

    .sidelist {
        position: absolute;
        top: 1em;
        left: 1em;
        z-index: 3;

        span {
            display: block;
            font-family: 'Major Mono Display', monospace;
            color: rgba(255, 255, 255, .3);
            cursor: pointer;
            transition: all .3s ease;
            line-height: 1.25em;

            &:hover {
                color: rgba(255, 255, 255, .6)
            }
        }
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>