<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :key="message.id" :class="`message ${message.to === contact.id ? 'sent' : 'received'} `">
                <span class="text">
                    {{ message.message }}
                    <small class="badge" ><i class="far fa-clock"></i> {{ message.created_at | msgTime }}</small>
                </span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "MessagesFeed",

        props: {
            contact: {
                type: Object,
                default: null
            },
            messages: {
                type: Array,
                default: []
            }
        },

        methods: {
            scrollToBottom() {
                setTimeout(() => {
                    this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
                }, 150);
            }
        },

        watch: {
            contact(contact) {
                this.scrollToBottom();
            },
            messages(messages) {
                this.scrollToBottom();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .feed {
        background: white;
        height: 100%;
        max-height: 266px;
        overflow-y: scroll;

        ul {
            list-style-type: none;
            padding: 5px;

            li {
                &.message {
                    margin: 10px 0;
                    width: 100%;

                    .text {
                        max-width: 200px;
                        border-radius: 5px;
                        padding: 12px;
                        display: inline-block;
                    }

                    &.received {
                        text-align: left;
                        .text {
                            background: #4ab9db;
                        }
                    }

                    &.sent {
                        text-align: right;
                        .text {
                            background: #24c983;
                        }
                    }
                }
            }
        }
    }
</style>