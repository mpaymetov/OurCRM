import React, {Component} from 'react';

class AddButton extends Component {

    render() {
        return(
                <a href={this.props.buttonInfo.path} className="btn btn-success">{this.props.buttonInfo.buttonName}</a>
        );
    }

}

export default AddButton;