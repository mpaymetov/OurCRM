import React, {Component} from 'react';
import ItemEvent from "./itemEvent";


class EventView extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
        this.componentWillMount();
    }
    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({ jsonData: data.items }))
            .catch((error) => {
                console.error(error);
            });
    }
}

export default EventView;
