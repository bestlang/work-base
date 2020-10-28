<?php
class LaraCmsSeeder
{
    public function run()
    {
        $this->call(CmsTagsTableSeeder::class);
        $this->call(CmsPositionsTableSeeder::class);
        $this->call(CmsPositionContentsTableSeeder::class);
        $this->call(CmsPositionChannelsTableSeeder::class);
        $this->call(CmsOrdersTableSeeder::class);
        $this->call(CmsModelsTableSeeder::class);
        $this->call(CmsModelFieldsTableSeeder::class);
        $this->call(CmsFieldTypesTableSeeder::class);
        $this->call(CmsContentsTableSeeder::class);
        $this->call(CmsContentTagsTableSeeder::class);
        $this->call(CmsContentMetasTableSeeder::class);
        $this->call(CmsContentContentsTableSeeder::class);
        $this->call(CmsCommentsTableSeeder::class);
        $this->call(CmsChannelsTableSeeder::class);
        $this->call(CmsChannelMetasTableSeeder::class);
        $this->call(CmsChannelContentsTableSeeder::class);
        $this->call(CmsAdsTableSeeder::class);
        $this->call(CmsAdPositionsTableSeeder::class);
    }
}