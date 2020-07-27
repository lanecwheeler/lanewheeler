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
            <div class="contactForm">
                <div>
                    <input required v-model="name" title="Name" id="name" type="text" name="name">
                    <label for="name">Name</label>
                </div>
                <div>
                    <input required v-model="email" title="Email" id="email" type="text" name="email">
                    <label for="email">Email</label>
                </div>
                <div>
                    <textarea required v-model="message" id="message" rows="5">{{message}}</textarea>
                    <label for="message">Message (optional)</label>
                </div>

                <div>
                    <select required id="favorite" v-model="selectedFavorite">
                        <option selected disabled></option>
                        <option v-for="option in favorites[randomFav].options">{{option}}</option>
                    </select>
                    <label for="favorite">Favorite {{favorites[randomFav].item}}</label>
                </div>

                <button class="send" @click="send()">gonna send it!</button>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                title: 'well hey there ;)',
                photoUrl: 'https://source.unsplash.com/collection/11521439?v=2',
                name: '',
                email: '',
                message: '',
                selectedFavorite: '',
                favorites: [
                    {item: 'Animal', options: ['Pangolin', 'Axolotl', 'Gharial', 'Pallas’s cat', 'Kakapo']},
                    {item: 'All-American Food', options: ['Glizzy', 'Tator-Tot Casserole', 'Spray Cheese', 'Deep-Fried Butter', 'Spam']},
                    {item: 'Music Genre', options: ['Nintendocore', 'Pirate Metal', 'Catholic Psychedelic Synth Folk', 'Danger Music', 'Crunkcore']}
                ]
            }
        },
        computed: {
            randomFav: function() {
                return Math.floor(Math.random() * (this.favorites.length - 1));
            }
        },
        methods: {
            send() {
                let dto = {
                    name: this.name,
                    email: this.email,
                    message: this.message,
                    favorite: this.favorites[this.randomFav].item,
                    selectedFavorite: this.selectedFavorite
                }

                axios.post('/contact-me/send-it', dto)
                    .then((res) => {
                        console.log(res.response);
                    })
                    .catch((err) => {
                        console.log(err);
                    })
                    .finally(() => {

                    })
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
        background-position: 30% 50%;
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

    .contactForm {
        display: flex;
        flex-direction: column;

        div {
            position: relative;

            input {
                width: 100%;
                margin: 1.5em 0 0 0;
                padding: .5em 2px;
                background: none;
                border: none;
                border-bottom: 1px solid white;
                transition: all .3s ease;
                color: white;
                font-family: "Bebas Neue", "sans-serif";
                font-size: 1.25em;

                &:hover {
                    border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                }

                &:focus {
                    outline: none;
                    border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, 1);
                }

                &:not(:invalid) + label, &:focus + label{
                    bottom: 2.5em;
                    color: white;
                }
            }

            textarea {
                width: 100%;
                margin: 1.5em 0 0 0;
                padding: .5em 2px;
                background: none;
                border: none;
                border-bottom: 1px solid white;
                transition: all .3s ease;
                color: white;
                font-family: "Bebas Neue", "sans-serif";
                font-size: 1.25em;

                &:hover {
                    border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                }

                &:focus {
                    outline: none;
                    border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, 1);
                }

                & + label {
                    bottom: auto;
                    top: 2.5em;
                }

                &:not(:invalid) + label, &:focus + label{
                    top: 1em;
                    color: white;
                }
            }

            select {
                width: 100%;
                margin: 1.5em 0 0 0;
                padding: .5em 0;
                background: none;
                border: none;
                border-bottom: 1px solid white;
                transition: all .3s ease;
                color: white;
                font-family: "Bebas Neue", "sans-serif";
                font-size: 1.25em;

                &:hover {
                    border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, .5);
                }

                &:focus {
                    outline: none;
                    border-bottom: 1px solid hsla(var(--base-hue-color), 100%, 50%, 1);
                }

                & + label {
                    bottom: auto;
                    top: 2.5em;
                }

                &:not(:invalid) + label, &:focus + label{
                    top: 1em;
                    color: white;
                }
            }

            label {
                position: absolute;
                bottom: 8px;
                left: 0;
                font-family: "Bebas Neue", "sans-serif";
                color: rgba(255,255,255,.5);
                transition: all .3s ease;
            }

        }

        .send {
            width: 100%;
            padding: .5em;
            text-align: center;
            color: hsla(var(--base-hue-color), 100%, 50%, 1);
            border: 1px solid hsla(var(--base-hue-color), 100%, 50%, 1);
            background: none;
            margin: 1.5em 0;
            transition: all .3s ease;
            font-family: "Major Mono Display", "sans-serif";
            font-size: 1.15em;

            &:hover, &:focus {
                color: black;
                background: hsla(var(--base-hue-color), 100%, 50%, 1);
            }
        }
    }

</style>