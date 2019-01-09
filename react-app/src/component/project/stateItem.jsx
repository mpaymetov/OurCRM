import React, {Component} from 'react';


class StateItem extends Component {

    constructor(props) {
        super(props);
        this.state = {class: "btn-success"};
    }

    render() {
        return (
            <a className={this.state.class}>{this.props.item}</a>
        );

    }

}

export default StateItem;
