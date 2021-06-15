export default class ErrorBag {
    #defaultBagName = 'default';

    constructor(bag = this.#defaultBagName) {
        this.collection = {};

        if (bag) {
            this.newBag(bag);
        }
    }

    newBag(name) {
        this.collection[name] = [];
    }

    resetBag(bag = this.#defaultBagName) {
        this.collection[bag] = [];
    }

    resetAll() {
        this.collection = {};
    }

    has(key, bag = this.#defaultBagName) {
        return this.collection[bag].includes(key);
    }

    get(key, bag = this.#defaultBagName) {
        return this.collection[bag].find(obj => obj.key === key);
    }

    getAll() {
        return this.collection;
    }

    push(key, value) {
        this.collection.push(this.#errorItem(key, value));
    }

    for(bag, callback) {
        const collection = this.collection[bag];

        for (const item in collection) {
            if (collection.hasOwnProperty(item)) {
                callback(collection[item], item);
            }
        }
    }

    static #errorItem(key, value) {
        return {key: key, value: value};
    }
}
