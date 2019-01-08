import React, {Component} from 'react';
import ItemEvent from './itemEvent.jsx';
import {Link, BrowserRouter} from 'react-router-dom';

const API = '/api/events';

class EventWarp extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }
    componentWillMount() {
        fetch(API)
            .then(response => response.json())
            .then(data => this.setState({ jsonData: data.items }))
            .catch((error) => {
                console.error(error);
            });
    }

    render() {
        console.log("in warp", this.state);
        if (this.state.jsonData !== '') {
            return (
                <div>
                    <ItemEvent items={this.state.jsonData}/>
                </div>
            )

        } else {
            return (<p>do not render</p>);
        }

    }
}
export default EventWarp;