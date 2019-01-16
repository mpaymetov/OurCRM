import React, {Component} from 'react';
import ItemPost from "./itemPost.jsx";


class FirstColumn extends Component {
    constructor(props) {
        super(props);
        this.state = {column: this.props.column};
    }

    render() {
        if (this.state.column.info.allModels.length > 0) {
            return (
                <ItemPost column={this.state.column.info.allModels}/>
            );
        }
        return <p></p>;
    }
}

export default FirstColumn