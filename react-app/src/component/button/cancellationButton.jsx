import React, {Component} from 'react';

class CancellationButton extends Component {

    render() {
        return(
            <a href={this.props.buttonInfo.path} className="btn btn_delete">{this.props.buttonInfo.buttonName}</a>
        );
    }

}

export default CancellationButton;