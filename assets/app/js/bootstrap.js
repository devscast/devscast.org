import { startStimulusApp } from '@symfony/stimulus-bridge';

import ScrollbarController from "./controllers/scrollbar_controller";
import SwitchThemeController from "./controllers/switch_theme_controller";
import SidebarController from "./controllers/sidebar_controller";
import ScrollableBoxController from "./controllers/scrollable_box_controller";
import TabController from "./controllers/tab_controller";
import CommentBlockController from "./controllers/comment_block_controller";
import DropdownController from "./controllers/dropdown_controller";
import ModalController from "./controllers/modal_controller";

export const app = startStimulusApp(undefined);

app.register('scrollbar', ScrollbarController);
app.register('switch-theme', SwitchThemeController);
app.register('sidebar', SidebarController);
app.register('scrollable-box', ScrollableBoxController);
app.register('tab', TabController);
app.register('comment-block', CommentBlockController);
app.register('dropdown', DropdownController);
app.register('modal', ModalController);
