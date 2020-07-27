<template>
    <div class="wrapper">

        <div type="color" style="display: none;" id="colorToMatch"></div>
        <h1 class="colorGame">
            The Great
            <br>
            <span id="colorDisplay">{{gameColor}}</span>
            <br>
            Color Game
        </h1>

        <div id="stripe">
            <div class="settings">
                <button @click="activeLvl = i; generateColors();" v-for="(level, i) in levels" class="mode" :class="{'selected' : activeLvl === i}">{{level.diff}}</button> |
                <button @click="activeType = i; generateColors();" v-for="(type, i) in codeTypes" class="code" :class="{'selected' : activeType === i}">{{type}}</button>
            </div>
            <div class="message">{{message}}</div>
        </div>

        <div class="squareContainer">
            <div v-for="(color, i) in currentColors">
                <div @click="checkColor(i)"
                     class="square"
                     :class="{'wrong' : color.correct === false}"
                     :style="'background: ' + getSquareColor(color)"></div>
            </div>
        </div>

        <button class="reset" @click="generateColors">New Colors</button>


    </div>
</template>

<script>

    export default {
        data() {
            return {
                levels : [
                    {diff: 'Easy', squares: 3},
                    {diff: 'Medium', squares: 6},
                    {diff: 'Hard', squares: 9},
                    {diff: 'Unreal', squares: 16},
                ],
                codeTypes : ['RGB', 'HEX'],
                activeLvl: 1,
                activeType: 0,
                currentColors: [],
                message: 'Try and match the color code shown to the colored square below!',
            }
        },
        computed: {
            gameColor: function () {
                return (this.currentColors.length > 0) ?
                    this.currentColors[Math.floor(Math.random() * this.currentColors.length)].code :
                    {code: "rgb(0,0,0)", correct: null}
            },
        },
        methods: {
            generateColors() {
                this.message = 'Try and match the color code shown to the colored square below!'
                this.currentColors = [];
                for (var i = 0; i < this.levels[this.activeLvl].squares; i++) {
                    switch(this.activeType) {
                        case 0: this.currentColors.push(this.randomRGBColor()); break;
                        case 1: this.currentColors.push(this.randomHexColor()); break;
                        default: this.currentColors.push(this.randomRGBColor());
                    }
                }
            },
            randomRGBColor() {
                var r = Math.floor(Math.random() * 256) //pick a "red" from 0 - 255
                var g = Math.floor(Math.random() * 256) //pick a "green" from 0 - 255
                var b = Math.floor(Math.random() * 256) //pick a "blue" from 0 - 255
                return {code: "rgb(" + r + ", " + g + ", " + b + ")", correct: null}
            },
            randomHexColor() {
                var hex = Math.floor(Math.random()*0xffffff).toString(16) //get a random integer within this range and then convert it to a string (it'll spit out a hex code)
                if(hex.length < 6) hex = '0' + hex //sometimes the leading 0 got axed, if it did, add it back
                return {code: '#' + hex, correct: null}
            },
            getSquareColor(color) {
                return (color.correct) ? this.gameColor : color.code;
            },
            checkColor(i) {
                if(this.currentColors[i].correct) {
                    return;
                } else if(this.gameColor === this.currentColors[i].code) {
                    this.currentColors.forEach((element) => {
                        element.correct = true;
                    });
                    this.message = 'You got it!'
                } else {
                    this.currentColors[i].correct = false;
                    this.message = 'Try Again!'
                }
            },
        },
        mounted() {
            this.generateColors();
        }
    }
</script>

<style lang="scss" scoped>
    h1.colorGame {
        color: rgba(0,0,0,1);
        font-family: "Bebas Neue", "sans-serif";
        font-size: 1.25em;
        text-align: center;
        text-transform: uppercase;
        line-height: 1.25;
        background: hsla(var(--base-hue-color), 100%, 50%, 1);
        margin: 0;
        /*add space to top and bottom of h1*/
        padding: 1.25em 0;
    }

    #colorDisplay {
        background: rgba(0,0,0,1);
        color: rgba(255,255,255,1);
        font-size: 1.75em;
        padding: .1em;
    }

    button {
        color: hsla(var(--base-hue-color), 100%, 50%, 1);
        font-weight: 700;
        font-size: inherit;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: none;
        outline: none;
        background: none;
        transition: all 0.3s ease;
        cursor: pointer;
        padding: .25em;

        &:hover {
            color: rgba(255,255,255,1);
            background: rgba(0,0,0,1);
        }
    }

    .selected {
        color: rgba(255,255,255,1);
        background: rgba(0,0,0,1);
        border: 1px solid hsla(var(--base-hue-color), 100%, 50%, 1);
    }

    .settings {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        padding: .5em;
        max-width: 650px;
        margin: auto;
    }

    .message {
        text-align: center;
        font-family: "Bebas Neue", "sans-serif";
        font-size: 1.25em;
        margin: .5em 0;
    }


    .squareContainer {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        max-width: 650px;
        margin: 0 auto;
        overflow: auto;

        & > div {
            flex: 1 0 150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

    .square {
        height: 100vw;
        width: 100vw;
        max-height: 150px;
        max-width: 150px;
        margin: 1em;
        transition: all .3s ease;
    }

    #stripe {
        background: rgba(0,0,0,1);
        text-align: center;
    }

    #message {
        width: 20%;
        display: inline-block;
    }

    .wrong {
        opacity: 0;
    }

    .reset {
        padding: 1em 0;
    }

</style>