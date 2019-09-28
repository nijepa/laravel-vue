<template>
    <div class="contacts-list">
        <ul>
            <li v-for="contact in sortedContacts" :key="contact.id"
                @click="selectContact(contact)" :class="{ 'selected': contact === selected}">
                <div class="avatar">
                    <img :src="'img/profile/'+contact.photo" :alt="contact.name">
                </div>
                <div class="contact">
                    <p class="name" :class="(onlineContacts.find(onlineContact=>onlineContact.id==contact.id)? 'green' : 'red')">
                        {{ contact.name }}
                    </p>
                    <p class="email">{{ contact.email }}</p>
                </div>
                <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "ContactsList",

        props: {
            contacts: {
                type: Array,
                default: []
            },
            onlineContacts: {
                type: Array,
                default: []
            }
        },

        data() {
            return {
                selected: this.contacts.length ? this.contacts[0] : null
            }
        },

        methods: {
            selectContact(contact) {
                this.selected = contact;
                this.$emit('selected', contact);
            }
        },

        computed: {
            sortedContacts() {
                return _.sortBy(this.contacts, [(contact) => {
                    if (contact === this.selected) {
                        return Infinity;
                    }
                    return contact.unread;
                }]).reverse();
            }
        }
    }
</script>

<style lang="scss" scoped>
    .green {
        color: #2fa360;
    }

    .red {
        color: #b91d19;
    }

    .contacts-list {
        flex: 2;
        max-height: 408px;
       // overflow: scroll;
        overflow-y: scroll;
        border-left: 1px solid lightskyblue;

        ul {
            list-style-type: none;
            padding-left: 0;

            li {
                display: flex;
                padding: 2px;
                border-bottom: 1px solid lightblue;
                height: 80px;
                position: relative;
                cursor: pointer;

                &.selected {
                    background: #4ab9db;
                }

                span.unread {
                    background: #5c9e76;
                    color: #fff;
                    position: absolute;
                    right: 11px;
                    top: 20px;
                    display: flex;
                    font-weight: 700;
                    min-width: 20px;
                    justify-content: center;
                    align-items: center;
                    line-height: 20px;
                    font-size: 12px;
                    padding: 0 4px;
                    border-radius: 3px;
                }

                .avatar {
                    flex: 1;
                    display: flex;
                    align-items: center;

                    img {
                        width: 35px;
                        border-radius: 50%;
                        margin: 0 auto;
                    }
                }

                .contact {
                    flex: 3;
                    font-size: 10px;
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;

                    p {
                        margin: 0;

                        &.name {
                            font-weight: bold;
                        }
                    }
                }
            }
        }
    }
</style>