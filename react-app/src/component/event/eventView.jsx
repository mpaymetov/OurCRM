import React, {Component} from 'react';

class EventView extends Component {
    constructor(props) {
        super(props);
        this.state = {jsonData: ''};
    }

    render() {
        return <div className="done">
            <p>Match: {JSON.stringify(this.props.match)}</p>
            <p>Location {JSON.stringify(this.props.location)}</p>
            <p>Id: {this.props.match.params.id}</p>
            <p>Name: {new URLSearchParams(this.props.location.search).get("name")}</p>
            <p>Age: {new URLSearchParams(this.props.location.search).get("age")}</p>
        </div>;

    }
}

export default EventView;
