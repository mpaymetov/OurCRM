import React, {Component} from 'react';


class ItemPost extends Component {
    constructor(props) {
        super(props);
        const rows = this.props.data;
    }

    render() {
        console.log('in component', this.props);
         return (
                <div>
                    <div>

                    </div>
                </div>
            )

    }
}

export default ItemPost;