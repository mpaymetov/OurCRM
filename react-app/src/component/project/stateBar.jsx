import React, {Component} from 'react';
import StateItem from './stateItem.jsx'


class StateBar extends Component {

    render() {
        return (
            <div className="btn-group btn-group-justified status-bar">
                {this.props.set.list.map((item) => <StateItem item = {item} />)}
            </div>
        );
    }

}

export default StateBar;