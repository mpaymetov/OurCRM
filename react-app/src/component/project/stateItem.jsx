import React, {Component} from 'react';


class StateItem extends Component {

    constructor(props) {
        super(props);
        this.state = {class: "btn-success"};
    }

    render() {

        if(this.props.item !== '') {
            return (
                <a className={this.state.class}>{this.props.item.listElem}</a>
            );
        } else {
            return (
                <div></div>
            );
        }

    }

}

export default StateItem;
