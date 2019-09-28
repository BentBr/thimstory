<template>
    <v-navigation-drawer
        v-model="drawer"
        :clipped="$vuetify.breakpoint.lgAndUp"
        app
    >
        <v-list dense>
            <template v-for="item in items">
                <v-row
                    v-if="item.heading"
                    :key="item.heading"
                    align="center"
                >
                    <v-col cols="6">
                        <v-subheader v-if="item.heading">
                            {{ item.heading }}
                        </v-subheader>
                    </v-col>
                    <v-col
                        cols="6"
                        class="text-center"
                    >
                        <a
                            href="#!"
                            class="body-2 black--text"
                        >EDIT</a>
                    </v-col>
                </v-row>
                <v-list-group
                    v-else-if="item.children"
                    :key="item.text"
                    v-model="item.model"
                    :prepend-icon="item.model ? item.icon : item['icon-alt']"
                    append-icon=""
                >
                    <template v-slot:activator>
                        <v-list-item>
                            <v-list-item-content>
                                <v-list-item-title>
                                    {{ item.text }}
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </template>
                    <v-list-item
                        v-for="(child, i) in item.children"
                        :key="i"
                        @click=""
                    >
                        <v-list-item-action v-if="child.icon">
                            <v-icon>{{ child.icon }}</v-icon>
                        </v-list-item-action>
                        <v-list-item-content>
                            <v-list-item-title>
                                {{ child.text }}
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-group>
                <v-list-item
                    v-else
                    :key="item.text"
                    @click=""
                >
                    <v-list-item-action>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>
                            {{ item.text }}
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </template>
        </v-list>
    </v-navigation-drawer>
</template>

<script>
    import store from "../store"

    export default {
        name: "NavigationDrawerComponent",
        props: {
            source: String,
        },
        data: () => ({
            items: [
                {icon: 'contacts', text: 'Contacts'},
                {icon: 'history', text: 'Frequently contacted'},
                {icon: 'content_copy', text: 'Duplicates'},
                {
                    icon: 'keyboard_arrow_up',
                    'icon-alt': 'keyboard_arrow_down',
                    text: 'Labels',
                    model: true,
                    children: [
                        {icon: 'add', text: 'Create label'},
                    ],
                },
                {
                    icon: 'keyboard_arrow_up',
                    'icon-alt': 'keyboard_arrow_down',
                    text: 'More',
                    model: false,
                    children: [
                        {text: 'Import'},
                        {text: 'Export'},
                        {text: 'Print'},
                        {text: 'Undo changes'},
                        {text: 'Other contacts'},
                    ],
                },
                {icon: 'settings', text: 'Settings'},
                {icon: 'chat_bubble', text: 'Send feedback'},
                {icon: 'help', text: 'Help'},
                {icon: 'phonelink', text: 'App downloads'},
                {icon: 'keyboard', text: 'Go to the old version'},
            ],
        }),
        computed: {
            drawer: {
                get: function() {
                    return store.getters.getDrawerState
                },
                set: function() {
                }
            },
        }
    }
</script>

<style scoped>

</style>
