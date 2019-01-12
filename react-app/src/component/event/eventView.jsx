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
            <p>Id: {this.props.match.params.id_event}</p>
        </div>;
    }
}
export default EventView;
